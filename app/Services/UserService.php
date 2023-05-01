<?php

namespace App\Services;

use App\Http\Controllers\AuthController;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class UserService
{
  public function handleUpdateError($id) {
    $user = User::find($id);
    $role = (new AuthController)->authRole();
    if (($role == 'Teacher' || $role == 'Pupil') && ($id != (auth()->user()->id_User ?? null)))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to update other users',
      ], 401);
    }
    else if ($role == 'School Administrator' && ((auth()->user()->fk_Schoolid_School ?? null) != $user->fk_Schoolid_School))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to update users from this school',
      ], 401);
    }
    else if(!$user) {
      return response()->json(['error' => 'User not found'], 404);
    }
    else return false;
  }
  public function update ($data, $userId): User
  {
    $user = User::find($userId);

    $user->update($data);

    return $user;
  }
  public function userShowErrorHandler($id) {
    $role = (new AuthController)->authRole();
    $user = User::find($id);

    if($role != 'System Administrator' && !($role === 'School Administrator' && ($user->fk_Schoolid_School === (auth()->user()->fk_Schoolid_School ?? null))))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }
    else if (!$user) {
      return response()->json([
        'status' => 'error',
        'message' => 'User not found',
      ], 404);
    }
    return false;
  }

  public function userDestroyErrorHandler($id): bool|JsonResponse
  {
    $role = (new AuthController)->authRole();
    $user = User::find($id);
    if($role != 'System Administrator' && !($role === 'School Administrator' && count($user->lessons()->get()) < 1 && $user->role === 'Pupil'))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }
    else if ($user == "") {
      return response()->json(['message' => 'User does not exist'], 404);
    }
    else if (count($user->lessons()->get()) > 0) {
      return response()->json(['message' => 'User has lessons attached'], 401);
    }
    else return false;
  }

  public function userIndexErrorHandler(): bool|JsonResponse
  {
    $role = (new AuthController)->authRole();
    $users = User::all();

    if($role != 'System Administrator')
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }
    else if (count($users) < 1) {
      return response()->json([
        'status' => 'error',
        'message' => 'No users found',
      ], 404);
    }
    else return false;
  }

  public function handleUserLessonTimes($class, $user) {
    $allLessons = $class->getAllLessons();
    $userLessons = $user->lessons()->where('fk_mainLessonsid_mainLessons', '!=', null)->get();

    if (count($allLessons) >= 1 && count($userLessons) >= 1) {
      if ($this->checkForCrossingTime($allLessons, $userLessons)) {
        return response()->json(['error' => 'User already has main lesson on this time'], 409);
      }
    }

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
}
