<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomStoreUpdateRequest;
use App\Services\ClassroomService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Http\Controllers\AuthController;

class ClassroomController extends Controller
{
  private ClassroomService $classroomService;

  public function __construct(ClassroomService $classroomService)
  {
    $this->classroomService = $classroomService;
    $this->middleware('auth:api', ['except' => []]);
  }

  function store(ClassroomStoreUpdateRequest $req, $idSchool)
  {
    $data = $req->validated();

    try {
      $handle = $this->classroomService->classroomsErrorHandler($idSchool);
      $exists = $this->classroomService->classroomExistance($idSchool, $data);

      if (!$handle && !$exists) {
        return $this->classroomService->create($data, $idSchool);
      } else {
        return $handle ?: $exists;
      }

    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
    }
  }

  function update($idSchool, $idClassroom, ClassroomStoreUpdateRequest $request)
  {
    $data = $request->validated();
    try {
      $handle = $this->classroomService->classroomsErrorHandler($idSchool);
      $exists = $this->classroomService->updatableClassroomExistance($idSchool, $idClassroom);
      if (!$handle && !$exists) {
        return $this->classroomService->update($data, $idClassroom);
      } else {
        return $handle ?: $exists;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
    }
  }

  function show($idSchool, $idClassroom)
  {
    try {
      $handle = $this->classroomService->classroomErrorHandler($idSchool);
      $exists = $this->classroomService->updatableClassroomExistance($idSchool, $idClassroom);

      if (!$handle && !$exists) {
        return Classroom::find($idClassroom);
      } else {
        return $handle ?: $exists;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
    }
  }

  function destroy($idSchool, $idClassroom)
  {
    try {
      $handle = $this->classroomService->classroomsErrorHandler($idSchool);
      $exists = $this->classroomService->updatableClassroomExistance($idSchool, $idClassroom);
      $lessons = $this->classroomService->classroomLessonExistance($idClassroom);
      $classroom = Classroom::find($idClassroom);

      if (!$handle && !$exists && !$lessons) {
        $classroom->delete();

        return response()->json(['success' => 'Classroom deleted']);
      } else {
        return $handle ?: $exists ?: $lessons;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
    }
  }

  function index($idSchool)
  {
    try {
      $handle = $this->classroomService->classroomErrorHandler($idSchool);
      $exists = $this->classroomService->classroomsExistance($idSchool);
      if (!$handle && !$exists) {
        return Classroom::where('classroom.fk_Schoolid_School','=',$idSchool)->get();
      } else {
        return $handle ?: $exists;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
    }
  }
}


