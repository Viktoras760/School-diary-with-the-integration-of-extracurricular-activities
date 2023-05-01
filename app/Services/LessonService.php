<?php

namespace App\Services;

use App\Http\Controllers\AuthController;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class LessonService
{

  public function lessonErrorHandler($idSchool, $idClassroom): bool|JsonResponse
  {
    $school = School::find($idSchool);
    $classroom = Classroom::find($idClassroom);
    $SchoolsClassroom = Classroom::where('fk_Schoolid_School', '=', $idSchool)->where('id_Classroom', '=', $idClassroom)->get();

    if(!$school) {
      return response()->json(['error' => 'School not found'], 404);
    }
    else if(!$classroom) {
      return response()->json(['error' => 'Classroom not found'], 404);
    }
    else if (count($SchoolsClassroom) < 1)
    {
      return response()->json(['error' => 'Classroom was not found in selected school'], 404);
    } else return false;
  }

  public function lessonGetErrorHandler($idSchool, $idClassroom, $id, $action): bool|JsonResponse
  {
    $role = (new AuthController)->authRole();
    $school = School::find($idSchool);
    $lesson = Lesson::find($id);
    if (($role == 'School Administrator' || $role == 'Teacher' || $role == 'Pupil') && ($school->id_School != (auth()->user()->fk_Schoolid_School ?? null)))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to get lessons in this school',
      ], 401);
    }
    else if (!$lesson) {
      return response()->json(['error' => 'Lesson not found'], 404);
    }
    else if ($action == 'get' && $role == 'Pupil' && ((auth()->user()->grade ?? null) < $lesson->lowerGradeLimit) || ($lesson->upperGradeLimit < (auth()->user()->grade ?? null))) {
      return response()->json([
        'status' => 'error',
        'message' => 'Lesson is not suitable for your grade',
      ], 401);
    }
    else if ($lesson->fk_Classroomid_Classroom != $idClassroom)
    {
      return response()->json(['error' => 'Lesson is in another classroom'], 404);
    }
    else return false;
  }

  public function lessonStoreErrorHandler ($schoolId, $data): bool|JsonResponse
  {
    $role = (new AuthController)->authRole();
    $school = School::find($schoolId);

    if($role != 'System Administrator' && $role != 'School Administrator'&& $role != 'Teacher')
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }
    else if (($role == 'School Administrator' || $role == 'Teacher') && ($school->id_School != (auth()->user()->fk_Schoolid_School ?? null)))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to add lessons in this school',
      ], 401);
    }
    else if ((new Carbon($data['lessonsStartingTime']))->gt(new Carbon($data['lessonsEndingTime'])))
    {
      return response()->json(['error' => 'Incorrect lesson time'], 404);
    }
    else return false;
  }

  public function lessonTimeHandler($data, $idClassroom, $action, $id): bool|JsonResponse
  {
    if ($action == 'store' || $action == 'update') {
      $lessons = Lesson::where('fk_Classroomid_Classroom', '=', $idClassroom)->get();
    } else {
      $lessons = auth()->user()->lessons()->get();
    }

    if (count($lessons) >= 1)
    {
      if ($this->checkForCrossingTime($lessons, $data, $id)) {
        if ($action == 'store' || $action == 'update') {
          return response()->json(['error' => 'This time is already occupied by another lesson'], 409);
        }
        else if ($action == 'register') {
          return response()->json(['error' => 'You already have lesson on this time'], 409);
        }
      }
    }
    return false;
  }

  public function activityTimeHandler($data): bool|JsonResponse
  {
    $lessons = auth()->user()->lessons()->get();

    if (count($lessons) >= 1)
    {
      if ($this->checkForCrossingTime($lessons, $data, -1)) {
        return response()->json(['error' => 'You already have lesson on this time'], 409);
      }
    }
    return false;
  }

  public function getAvailableLessons($classroomId): Collection
  {
    $available = collect([]);
    $lessons = Lesson::where('fk_Classroomid_Classroom' ,'=', $classroomId)
      ->where('lowerGradeLimit', '<=', (auth()->user()->grade ?? null))
      ->where('upperGradeLimit', '>=', (auth()->user()->grade ?? null))
      ->where('fk_nonscholasticActivityid_nonscholasticActivity', '!=', NULL)
      ->with(['creator', 'nonscholasticactivity'])
      ->get();
    $userLessons = auth()->user()->lessons()->get();
    if (count($userLessons) > 0) {
      foreach ($lessons as $lesson) {
        if (!$this->checkForCrossingTime($userLessons, $lesson, -1)) {
          $available->push($lesson);
        }
      }
    } else $available = $lessons;
    return $available;
  }


  public function update ($data, $lessonId): Lesson
  {
    $lesson = Lesson::find($lessonId);

    $lesson->update($data);

    return $lesson;
  }

  /**
   * @param $data
   * @param $idClassroom
   * @return Lesson
   */
  public function create($data, $idClassroom, $teacher): Lesson
  {
    $data['fk_Classroomid_Classroom'] = $idClassroom;

    $data['creatorId'] = ($teacher ?? null);

    return Lesson::create($data);
  }

  public function createCustom($data): Lesson
  {
    $data['fk_Classroomid_Classroom'] = 0;

    $data['creatorId'] = (auth()->user()->id_User ?? null);

    $lesson = Lesson::create($data);

    $lesson->users()->attach(auth()->user());

    return $lesson;
  }

  private function checkForCrossingTime($lessons, $data, $id)
  {
    for ($i = 0; $i < count($lessons); $i++)
    {
      if (strval($lessons[$i]->id_Lesson) !== $id) {

        //      12:00-12:45
        //11:15-12:00
        if ((new Carbon($data['lessonsStartingTime']))->eq(new Carbon($lessons[$i]->lessonsStartingTime)) || (new Carbon($data['lessonsEndingTime']))->eq(new Carbon($lessons[$i]->lessonsEndingTime)) || (new Carbon($data['lessonsEndingTime']))->eq(new Carbon($lessons[$i]->lessonsStartingTime)) || (new Carbon($data['lessonsStartingTime']))->eq(new Carbon($lessons[$i]->lessonsEndingTime))) {
          return true;
        }
        //12:00  -  12:45
        //  12:15-12:30
        if (((new Carbon($data['lessonsStartingTime'])) < (new Carbon($lessons[$i]->lessonsStartingTime)) && (new Carbon($data['lessonsEndingTime'])) > (new Carbon($lessons[$i]->lessonsEndingTime))) || ((new Carbon($data['lessonsStartingTime'])) > (new Carbon($lessons[$i]->lessonsStartingTime)) && (new Carbon($data['lessonsEndingTime'])) < (new Carbon($lessons[$i]->lessonsEndingTime)))) {
          return true;
        }
        //12:00-12:45
        //  12:00-13:00
        if (((new Carbon($data['lessonsStartingTime'])) > (new Carbon($lessons[$i]->lessonsStartingTime)) && (new Carbon($data['lessonsStartingTime'])) < (new Carbon($lessons[$i]->lessonsEndingTime))) || (new Carbon($data['lessonsEndingTime']) > (new Carbon($lessons[$i]->lessonsStartingTime)) && (new Carbon($data['lessonsEndingTime'])) < (new Carbon($lessons[$i]->lessonsEndingTime)))) {
          return true;
        }
      }
    }
    return false;
  }

  public function lessonDestroyErrorHandler($idSchool, $id) {

    $role = (new AuthController)->authRole();
    $school = School::find($idSchool);
    $lesson = Lesson::find($id);

    if($role != 'System Administrator' && $role != 'School Administrator'&& $role != 'Teacher')
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }

    else if (($role == 'School Administrator' || $role == 'Teacher' ) && ($school->id_School != (auth()->user()->fk_Schoolid_School ?? null)))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to delete lessons in this school',
      ], 401);
    }

    else if (!$lesson)
    {
      return response()->json(['error' => 'Lesson not found'], 404);
    }

    $lessonUsers = Lesson::find($id)->users()->get();

    if ($role == 'Teacher' && ((auth()->user()->id_User ?? null) != $lesson->creatorId))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to delete another teacher lesson',
      ], 401);
    }

    else if (count($lessonUsers))
    {
      return response()->json(['error' => 'Lesson has users registered'], 404);
    }
    return false;
  }

  public function lessonUpdateErrorHandler($data, $idSchool, $idClassroom, $id) {
    $role = (new AuthController)->authRole();
    $lesson = Lesson::find($id);
    $school = School::find($idSchool);

    if($role != 'System Administrator' && $role != 'School Administrator'&& $role != 'Teacher')
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }

    else if (($role == 'School Administrator' || $role == 'Teacher' ) && ($school->id_School != (auth()->user()->fk_Schoolid_School ?? null)))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to add lessons in this school',
      ], 401);
    }

    else if (!$lesson)
    {
      return response()->json(['error' => 'Lesson not found'], 404);
    }
    else if ($role == 'Teacher' && ((auth()->user()->id_User ?? null)!= $lesson->creatorId))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to update another teacher lesson',
      ], 401);
    }

    $lessonUsers = Lesson::find($id)->users()->get();

    if(count($lessonUsers) && $data['lowerGradeLimit'] != $lesson->lowerGradeLimit)
    {
      return response()->json(['error' => 'Lesson has users registered'], 404);
    }
    else return false;
  }

  public function userLessonsErrorHandler(): bool|JsonResponse
  {
    if (count(User::find(auth()->user()->id_User ?? null)->lessons()->get()) < 1) {
      return response()->json(['error' => 'User has no lessons'], 404);
    }
    return false;
  }
}
