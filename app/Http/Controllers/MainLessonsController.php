<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainLessonsStoreUpdateRequest;
use App\Http\Requests\SchoolStoreUpdateRequest;
use App\Models\MainLessons;
use App\Models\School;
use App\Services\MainLessonService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class MainLessonsController extends Controller
{
  private MainLessonService $mainLessonService;
  public function __construct(MainLessonService $mainLessonService)
  {
    $this->mainLessonService = $mainLessonService;
    $this->middleware('auth:api', ['except' => []]);
  }

  function index(): Collection|JsonResponse
  {
    $mainLessons = MainLessons::all();
    if (count($mainLessons) > 0) {
      $handler = false;
    } else {
      $handler = response()->json(['message' => 'Main lessons not found'], 404);
    }

    if (!$handler) {
      return $mainLessons;
    } else {
      return $handler;
    }
  }

  function store(MainLessonsStoreUpdateRequest $req): JsonResponse|MainLessons
  {
    $data = $req->validated();

    try {
      $handle = $this->mainLessonService->mainLessonErrorHandler($data);

      if (!$handle) {
        return $this->mainLessonService->create($data);
      } else {
        return $handle;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Main lesson adding failed'], 422);
    }
  }

}
