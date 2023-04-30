<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonStoreUpdateRequest;
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
    try {
      $handle = $this->lessonService->lessonErrorHandler($idSchool, $idClassroom);
      $handleStore = $this->lessonService->lessonStoreErrorHandler($idSchool, $data);
      $timeSuitability = $this->lessonService->lessonTimeHandler($data, $idClassroom, 'store');
      if (!$handle && !$handleStore && !$timeSuitability)
      {
        return $this->lessonService->create($data, $idClassroom);
      } else {
        return $handle ?: $handleStore ?: $timeSuitability;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
    }
  }

  function registerToLesson($idSchool, $idClassroom, $id): JsonResponse|bool
  {
    try {
      $userLessons = auth()->user()->lessons()->get();
      $lesson = Lesson::find($id);
      $timeSuitability = false;

      $handle = $this->lessonService->lessonErrorHandler($idSchool, $idClassroom);
      $handle2 = $this->lessonService->lessonGetErrorHandler($idSchool, $idClassroom, $id, 'get');
      if (!$handle && !$handle2 && count($userLessons) > 0) {
        $timeSuitability = $this->lessonService->lessonTimeHandler($lesson->toArray(), $idClassroom, 'register');
      }

      if (!$handle && !$handle2 && !$timeSuitability)
      {
        $lesson->users()->attach(auth()->user());

        return response()->json(['success' => 'Successfully registered']);
      } else {
        return $handle ?: $handle2 ?: $timeSuitability;
      }

    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
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
      else {
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
      $timeSuitability = $this->lessonService->lessonTimeHandler($data, $idClassroom, 'update');

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
        $userLessons = User::find(auth()->user()->id_User ?? null)->lessons()->orderBy('lessonsStartingTime', 'asc')->get();
      } else return $handle;

      return $userLessons;
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
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
        $lessons2 = $availableLessons->where('lessonsStartingTime', '>=', $date)->where('lessonsStartingTime', '<', $endDate)->with(['creator', 'nonscholasticactivity'])->get();
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
}
