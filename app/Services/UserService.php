<?php

namespace App\Services;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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
}
