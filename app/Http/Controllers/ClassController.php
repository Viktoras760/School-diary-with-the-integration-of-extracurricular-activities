<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassStoreUpdateRequest;
use App\Http\Requests\SchoolStoreUpdateRequest;
use App\Models\ClassModel;
use App\Models\MainLessons;
use App\Models\School;
use App\Services\ClassService;
use App\Services\MainLessonService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class ClassController extends Controller
{
  private ClassService $classService;
  public function __construct(ClassService $classService)
  {
    $this->classService = $classService;
    $this->middleware('auth:api', ['except' => []]);
  }

  function index(): Collection|JsonResponse
  {
    $class = ClassModel::all()->load('teacher');
    if (count($class) > 0) {
      $handler = false;
    } else {
      $handler = response()->json(['message' => 'Classes not found'], 404);
    }

    if (!$handler) {
      return $class;
    } else {
      return $handler;
    }
  }

  function store(ClassStoreUpdateRequest $req): JsonResponse|ClassModel
  {
    $data = $req->validated();

    try {
      $handle = $this->classService->classErrorHandler($data);
      if (!$handle) {
        return $this->classService->create($data);
      } else {
        return $handle;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Class creation failed'], 422);
    }
  }

  function destroy($id): JsonResponse
  {
    try {
      $class = ClassModel::find($id);

      $handle = $this->classService->classDeletionErrorHandler($class);

      if (!$handle) {
        $class->delete();

        return response()->json(['success' => 'Class deleted']);

      } else {
        return $handle;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Class deletion failed'], 422);
    }
  }

  function show($id)
  {
    $class = ClassModel::with(['users', 'teacher'])->find($id);

    return $class;
  }
}
