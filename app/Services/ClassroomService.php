<?php

namespace App\Services;

use App\Http\Controllers\AuthController;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\School;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class ClassroomService
{
  public function classroomsErrorHandler($idSchool): bool|JsonResponse
  {
    $role = (new AuthController)->authRole();
    $school = School::find($idSchool);

    if($role != 'System Administrator' && $role != 'School Administrator')
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to do that',
      ], 401);
    }

    else if ($role == 'School Administrator' && ($school->id_School != (auth()->user()->fk_Schoolid_School ?? null)))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to add or update classroom at this school',
      ], 401);
    }

    else if(!$school) {
      return response()->json(['error' => 'School not found'], 404);
    }

    else return false;
  }

  public function classroomExistance ($idSchool, $data): bool|JsonResponse
  {
    $classroomEx = Classroom::where('fk_Schoolid_School', '=', $idSchool)->where('number', '=', $data['number'])->get();

    if (count($classroomEx) > 0)
    {
      return response()->json(['error' => 'Classroom with such number already exists in this school'], 404);
    } else return false;
  }

  public function updatableClassroomExistance ($idSchool, $idClassroom): bool|JsonResponse
  {
    $classroom = Classroom::find($idClassroom);
    $SchoolsClassroom = Classroom::where('fk_Schoolid_School', '=', $idSchool)->where('id_Classroom', '=', $idClassroom)->get();

    if(!$classroom) {
      return response()->json(['error' => 'Classroom not found'], 404);
    }
    else if (count($SchoolsClassroom) < 1)
    {
      return response()->json(['error' => 'Classroom is in another school.'], 404);
    }
    else return false;
  }

  public function classroomErrorHandler ($idSchool): bool|JsonResponse
  {
    $role = (new AuthController)->authRole();
    $school = School::find($idSchool);
    if (($role == 'School Administrator' || $role == 'Teacher' || $role == 'Pupil') && ($school->id_School != (auth()->user()->fk_Schoolid_School ?? null)))
    {
      return response()->json([
        'status' => 'error',
        'message' => 'No rights to get classroom in this school',
      ], 401);
    }
    else if(!$school) {
      return response()->json(['error' => 'School not found'], 404);
    }

    else return false;
  }

  public function classroomsExistance($idSchool): bool|JsonResponse
  {
    $classrooms = Classroom::where('classroom.fk_Schoolid_School','=',$idSchool)->get();

    if (count($classrooms) < 1) {
      return response()->json(['message' => 'Classrooms not found'], 404);
    }

    else return false;
  }

  public function classroomLessonExistance ($idClassroom) {
    $lesson = Lesson::where('fk_Classroomid_Classroom', '=', $idClassroom)->get();

    if (count($lesson) > 1)
    {
      return response()->json(['error' => 'Classroom has lesson(s). Cannot delete', $lesson], 404);
    } else return false;
  }

  public function update ($data, $classroomId): JsonResponse
  {
    try {
      $classroom = Classroom::find($classroomId);

      $classroom->update($data);

      return response()->json(['success' => 'Classroom updated successfully']);
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
    }


  }

  /**
   * @param $data
   * @param $idSchool
   * @return Classroom
   */
  public function create($data, $idSchool): Classroom
  {
    $data['fk_Schoolid_School'] = $idSchool;

    return Classroom::create($data);
  }

}
