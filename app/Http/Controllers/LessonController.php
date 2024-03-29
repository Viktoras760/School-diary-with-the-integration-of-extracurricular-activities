<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonStoreUpdateRequest;
use App\Models\ClassModel;
use App\Services\LessonService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;
use App\Models\School;
use App\Models\Classroom;
use Illuminate\Support\Carbon;
use App\Http\Controllers\AuthController;
use Illuminate\Validation\ValidationException;

class LessonController extends Controller
{
  private LessonService $lessonService;
  public function __construct(LessonService $lessonService)
  {
    $this->lessonService = $lessonService;
    $this->middleware('auth:api', ['except' => []]);
  }

  function show($idSchool, $idClassroom, $id)
  {
    try {
      $handle = $this->lessonService->lessonGetErrorHandler($idSchool, $idClassroom, $id, 'get');
      $exists = $this->lessonService->lessonErrorHandler($idSchool, $idClassroom);

      if (!$handle && !$exists) {
        return Lesson::find($id);
      } else {
        return $handle ?: $exists;
      }

    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
    }
  }

  function store(LessonStoreUpdateRequest $req, $idSchool, $idClassroom): Lesson|JsonResponse|bool
  {
    $data = $req->validated();
    $teacher = $req->teacher;
    try {
      $handle = $this->lessonService->lessonErrorHandler($idSchool, $idClassroom);
      $handleStore = $this->lessonService->lessonStoreErrorHandler($idSchool, $data);
      $timeSuitability = $this->lessonService->lessonTimeHandler($data, $idClassroom, 'store', null);
      if (!$handle && !$handleStore && !$timeSuitability)
      {
        return $this->lessonService->create($data, $idClassroom, $teacher);
      } else {
        return $handle ?: $handleStore ?: $timeSuitability;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
    }
  }

  function addCustomActivity(LessonStoreUpdateRequest $req): Lesson|JsonResponse|bool
  {
    $data = $req->validated();
    try {
      $timeSuitability = $this->lessonService->activityTimeHandler($data);
      if ( !$timeSuitability)
      {
        return $this->lessonService->createCustom($data);
      } else {
        return $timeSuitability;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Activity creation failed'], 422);
    }
  }

  function registerToLesson(Request $req, $idSchool, $idClassroom, $id): JsonResponse|bool
  {
    $teacher = $req->teacher;
    $classId = $req->class;
    $class = null;
    $pupils = null;
    $pupilLessons = null;
    if ($classId) {
      $class = ClassModel::with('users')->find($classId);
      $pupils = $class->users;
      $pupil = $class->users->first();
      if ($pupil) {
        $pupilLessons = $pupil->lessons()->where('fk_mainLessonsid_mainLessons', '!=', null)->get();
      }
    }
    try {
      if ($teacher) {
        $user = User::where('id_User', '=', $teacher)->with('lessons')->get();
        $userLessons = $user[0]->lessons()->get();
      } else {
        $userLessons = auth()->user()->lessons()->get();
      }
      $lesson = Lesson::find($id);
      $timeSuitability = false;

      $handle = $this->lessonService->lessonErrorHandler($idSchool, $idClassroom);
      if (!$teacher) {
        $handle2 = $this->lessonService->lessonGetErrorHandler($idSchool, $idClassroom, $id, 'get');
        if (!$handle && !$handle2 && count($userLessons) > 0) {
          $timeSuitability = $this->lessonService->lessonTimeHandler($lesson->toArray(), $idClassroom, 'register', null);
          if (!$timeSuitability && $class) {
            $timeSuitability = $this->lessonService->userLessonTimeHandler($pupilLessons, $lesson->toArray(), 'class');
          }
        }

        if (!$handle && !$handle2 && !$timeSuitability)
        {
          $lesson->users()->attach(auth()->user());

          if ($pupils){
            foreach($pupils as $pupil) {
              $lesson->users()->attach($pupil);
            }
          }

          return response()->json(['success' => 'Successfully registered']);
        } else {
          return $handle ?: $handle2 ?: $timeSuitability;
        }
      } else {
        $lesson = Lesson::find($id);

        if (!$handle) {
          if (count($userLessons) > 0) {
            $timeSuitability = $this->lessonService->userLessonTimeHandler($userLessons, $lesson->toArray(), 'teacher');
          } else if (!$timeSuitability && $class && $pupils && $pupilLessons) {
            $timeSuitability = $this->lessonService->userLessonTimeHandler($pupilLessons, $lesson->toArray(), 'class');
          }
        }

        if (!$handle && !$timeSuitability)
        {
          $lesson->users()->attach($user);

          if ($pupils){
            foreach($pupils as $pupil) {
              $lesson->users()->attach($pupil);
            }
          }

          return response()->json(['success' => 'Successfully registered']);
        } else {
          return $handle ?: $timeSuitability;
        }
      }

    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function registerToCourse($idSchool, $idClassroom, $id): JsonResponse|bool
  {
    try
    {
      $userLessons = auth()->user()->lessons()->get();

      $lesson = Lesson::find($id);
      $courseLessons = Lesson::where('fk_Classroomid_Classroom', '=', $idClassroom)->where('lessonName', '=', $lesson->lessonName)->where('creatorId', '=', $lesson->creatorId)->where('lowerGradeLimit', '=', $lesson->lowerGradeLimit)->where('type', '=', $lesson->type)->get();
      $timeSuitability = false;

      $handle = $this->lessonService->lessonErrorHandler($idSchool, $idClassroom);
      $handle2 = $this->lessonService->lessonGetErrorHandler($idSchool, $idClassroom, $id, 'get');
      if (!$handle && !$handle2 && count($userLessons) > 0) {
        foreach ($courseLessons as $lesson1) {
          $timeSuitability = $this->lessonService->lessonTimeHandler($lesson1->toArray(), $idClassroom, 'register', null);
          if ($timeSuitability) {
            return $timeSuitability;
          }
        }
      }
      if (!$handle && !$handle2 && !$timeSuitability)
      {
        foreach ($courseLessons as $lesson2) {
          $lesson2->users()->attach(auth()->user());
        }
        return response()->json(['success' => 'Successfully registered']);
      } else {
        return $handle ?: $handle2 ?: $timeSuitability;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Register to course failed'], 422);
    }
  }

  function unregisterFromCourse($idClassroom, $id): JsonResponse
  {
    try {
      $lesson = Lesson::find($id);
      $courseLessons = Lesson::where('fk_Classroomid_Classroom', '=', $idClassroom)->where('lessonName', '=', $lesson->lessonName)->where('creatorId', '=', $lesson->creatorId)->where('lowerGradeLimit', '=', $lesson->lowerGradeLimit)->where('type', '=', $lesson->type)->get();


      if ($courseLessons) {
        foreach ($courseLessons as $lesson2) {
          $lesson2->users()->detach(auth()->user());
        }
      } else {
        return response()->json(['error' => 'Lesson course not found'], 404);
      }

      return response()->json(['success' => 'Successfully unregistered']);
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Unregister failed'], 422);
    }
  }

  function destroy($idSchool, $idClassroom, $id): JsonResponse|bool
  {
    try {
      $handle = $this->lessonService->lessonErrorHandler($idSchool, $idClassroom);
      $exists = $this->lessonService->lessonDestroyErrorHandler($idSchool, $id);

      $lesson = Lesson::find($id);

      if (!$handle && !$exists) {
        $lesson->delete();

        return response()->json(['success' => 'Lesson deleted']);
      }
      else if (is_int($exists)) {
        foreach ($lesson->userLessons as $userLesson) {
          $userLesson->delete();
        }

        $lesson->delete();

        return response()->json(['success' => 'Lesson deleted']);
      } else {
        return $handle ?: $exists;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function unregisterFromLesson($id): JsonResponse
  {
    try {
      $lesson = Lesson::find($id);

      if ($lesson) {
        $lesson->users()->detach(auth()->user());
      } else {
        return response()->json(['error' => 'Lesson not found'], 404);
      }

      return response()->json(['success' => 'Successfully unregistered']);
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Unregister failed'], 422);
    }
  }

  function update(LessonStoreUpdateRequest $request, $idSchool, $idClassroom, $id): Lesson|JsonResponse|bool
  {
    $data = $request->validated();

    try {
      $handle = $this->lessonService->lessonErrorHandler($idSchool, $idClassroom);
      $handle2 = $this->lessonService->lessonUpdateErrorHandler($data, $idSchool, $idClassroom, $id);
      $timeSuitability = $this->lessonService->lessonTimeHandler($data, $idClassroom, 'update', $id);

      if (!$handle && !$handle2 && !$timeSuitability) {
        return $this->lessonService->update($data, $id);
      }
      else {
        return $handle ?: $handle2 ?: $timeSuitability;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function getUserLessons()
  {
    try {
      $handle = $this->lessonService->userLessonsErrorHandler();
      if (!$handle) {
        $userLessons = User::find(auth()->user()->id_User ?? null)->lessons()->orderBy('lessonsStartingTime', 'asc')->with('classroom')->get();
      } else return $handle;

      return $userLessons;
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function getLessonUsers($id)
  {
    try {
      $handle = $this->lessonService->lessonUsersErrorHandler($id);
      if (!$handle) {
        $lessonUsers = Lesson::with('userLessons', 'users')->find($id);
      } else return $handle;

      return $lessonUsers;
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Lesson has no users'], 422);
    }
  }

  function index($schoolId, $classroomId, Request $req): Collection|JsonResponse|array
  {
    $date = $req->date;
    $secondary = $req->showOnlySecondary;
    $available = $req->showOnlyAvailable;
    try {
      if ($date && $secondary && $available) {
        $availableLessons = $this->lessonService->getAvailableLessons($classroomId);
        $endDate = Carbon::parse($date)->addDay()->format('Y-m-d');
        $lessons2 = $availableLessons->where('lessonsStartingTime', '>=', $date)->where('lessonsStartingTime', '<', $endDate);
        $data = json_decode($lessons2, true);
        $lessons = array_values($data);
      } else if ($date && $secondary) {
        $endDate = Carbon::parse($date)->addDay()->format('Y-m-d');
        $lessons = Lesson::where('fk_Classroomid_Classroom' ,'=', $classroomId)->where('lessonsStartingTime', '>=', $date)->where('lessonsStartingTime', '<', $endDate)->where('fk_nonscholasticActivityid_nonscholasticActivity', '!=', NULL)->with(['creator', 'nonscholasticactivity'])->get();
      } else if ($date && $available) {
        $availableLessons = $this->lessonService->getAvailableLessons($classroomId);
        $endDate = Carbon::parse($date)->addDay()->format('Y-m-d');
        $lessons2 = $availableLessons->where('fk_Classroomid_Classroom' ,'=', $classroomId)->where('lessonsStartingTime', '>=', $date)->where('lessonsStartingTime', '<', $endDate)->where('fk_nonscholasticActivityid_nonscholasticActivity', '!=', NULL);
        $data = json_decode($lessons2, true);
        $lessons = array_values($data);
      } else if ($date) {
        $endDate = Carbon::parse($date)->addDay()->format('Y-m-d');
        $lessons = Lesson::where('fk_Classroomid_Classroom' ,'=', $classroomId)->where('lessonsStartingTime', '>=', $date)->where('lessonsStartingTime', '<', $endDate)->with(['creator', 'nonscholasticactivity'])->get();
      } else if ($secondary) {
        $lessons = Lesson::where('fk_Classroomid_Classroom' ,'=', $classroomId)->where('fk_nonscholasticActivityid_nonscholasticActivity', '!=', NULL)->with(['creator', 'nonscholasticactivity'])->get();
      } else if ($available) {
        $lessons2 = $this->lessonService->getAvailableLessons($classroomId);
        $data = json_decode($lessons2, true);
        $lessons = array_values($data);
      } else {
        $lessons = Lesson::where('fk_Classroomid_Classroom' ,'=', $classroomId)->with(['creator', 'nonscholasticactivity'])->get();
      }
      if (count($lessons) < 1)
      {
        return response()->json(['error' => 'There are no lessons'], 404);
      }
      return $lessons;
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function getTeachersLessons()
  {
    try {
      $lessons = Lesson::where('creatorId', '=', auth()->user()->id_User ?? null)->orderBy('lessonsStartingTime', 'asc')->get();
      if (count($lessons) < 1)
      {
        return response()->json(['error' => 'There are no lessons'], 404);
      }

      return $lessons;
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }

  }

  function getUserLessonsCustom(Request $request) {
    $startDate = $request->startDate;
    $endDate = $request->endDate;
    $all = $request->all;
    $userId = auth()->user()->id_User ?? null;

    try {
      $handle = $this->lessonService->userLessonsErrorHandler();
      if (!$handle) {
        if ($all) {
          $userLessons = User::find($userId)
            ->lessons()
            ->whereBetween('lessonsStartingTime', [$startDate, $endDate])
            ->where('type', '!=', 3)
            ->orderBy('lessonsStartingTime', 'asc')
            ->with(['classroom', 'mainLessons', 'userLessons' => function ($query) use ($userId) {
              $query->where('fk_Userid_User', $userId);
            }])
            ->get();
        } else {
          $userLessons = User::find($userId)
            ->lessons()
            ->whereBetween('lessonsStartingTime', [$startDate, $endDate])
            ->where('type', '=', 1)
            ->orderBy('lessonsStartingTime', 'asc')
            ->with(['classroom', 'mainLessons', 'userLessons' => function ($query) use ($userId) {
              $query->where('fk_Userid_User', $userId);
            }])
            ->get();
        }
      } else return $handle;

      return $userLessons;
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function getLesson($id) {
    $lesson = Lesson::find($id);

    if (!$lesson) {
      return response()->json(['error' => 'Lesson was not found'], 404);
    } else return $lesson;
  }

  public function getSubjects(Request $request) {
    if (!auth()->check()) {
      return response()->json(['error' => 'Unauthenticated'], 401);
    }

    $user = auth()->user();

    try {
      $validated = $request->validate([
        'startDate' => 'required|date',
        'endDate' => 'required|date',
      ]);
    } catch (ValidationException $e) {
      return response()->json(['error' => 'Invalid or missing parameters'], 400);
    }

    $startDate = $validated['startDate'];
    $endDate = $validated['endDate'];

    $lessons = Lesson::where('creatorId', '=', $user->id_User ?? null)
      ->where('fk_mainLessonsid_mainLessons', '!=', null)
      ->whereBetween('lessonsStartingTime', [$startDate, $endDate])
      ->whereBetween('lessonsEndingTime', [$startDate, $endDate])
      ->with('mainLessons.classModel')
      ->get();

    $mainLessons = $lessons->map(function ($lesson) {
      if ($lesson->mainLessons) {
        return $lesson->mainLessons;
      }
    })->unique('id_mainLessons');

    return $mainLessons;
  }

  function getExtracurricular()
  {
    try {
      $classrooms = Classroom::where('fk_Schoolid_School', '=', auth()->user()->fk_Schoolid_School ?? null)->get();

      $lessons = Lesson::whereNotNull('fk_nonscholasticActivityid_nonscholasticActivity')
        ->whereIn('fk_Classroomid_Classroom', $classrooms->pluck('id_Classroom'))->with('classroom')
        ->get();

      return $lessons;
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }
}
