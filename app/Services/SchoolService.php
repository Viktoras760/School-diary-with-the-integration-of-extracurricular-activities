<?php

namespace App\Services;

use App\Http\Controllers\AuthController;
use App\Models\School;
use App\Models\User;

class SchoolService
{
  public function schoolErrorHandler($schoolId): bool|\Illuminate\Http\JsonResponse
  {
    $school = School::find($schoolId);
    $role = (new AuthController)->authRole();

    if($role != 'System Administrator' && $role != 'School Administrator')
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }

    else if (($role == 'School Administrator' && $school->id_School != (auth()->user()->fk_Schoolid_School ?? null)) && $role != 'System Administrator')
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to update this school',
      ], 401);
    }

    else if(!$school) {
      return response()->json(['error' => 'School not found'], 404);
    }

    else return false;
  }

  public function update ($schoolId, $data): School
  {
    $school = School::find($schoolId);

    $school->update($data);

    return $school;
  }

  public function schoolsErrorHandler($action): bool|\Illuminate\Http\JsonResponse
  {
    $schools = School::all();
    $role = (new AuthController)->authRole();

    if($role != 'System Administrator')
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }

    if (!$schools && $action == 'get') {
      return response()->json(['message' => 'Schools not found'], 404);
    }

    return false;
  }

  public function schoolDeletionErrorHandler($schoolId): bool|\Illuminate\Http\JsonResponse
  {
    $role = (new AuthController)->authRole();

    $user = User::where('user.fk_Schoolid_School','=',$schoolId)->get();
    $school = School::find($schoolId);

    if($role != 'System Administrator')
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }
    else if ($school == "") {
      return response()->json(['message' => 'School does not exist'], 404);
    }
    else if (count($user) > 0)
    {
      return response()->json(['message' => 'School has users attached. Delete them first.'], 400);
    }

    return false;
  }

  /**
   * @param $data
   * @return School
   */
  public function create($data): School
  {
    $school = School::create($data);
    return $school;
  }

  public function schoolExistance($data) {
    $schools = School::where('name', '=', $data['name'])->get();
    $address = School::where('address', '=', $data['address'])->get();

    if(count($schools) > 0 || count($address) > 0) {
      return response()->json(['message' => 'School already exist'], 400);
    } else return false;
  }
}
