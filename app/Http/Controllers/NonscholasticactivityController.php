<?php

namespace App\Http\Controllers;

use App\Http\Requests\NonscholasticactivityStoreUpdateRequest;
use App\Http\Requests\SchoolStoreUpdateRequest;
use App\Models\Lesson;
use App\Models\MainLessons;
use App\Models\Nonscholasticactivity;
use App\Models\School;
use App\Services\NonscholasticactivityService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class NonscholasticactivityController extends Controller
{
  private NonscholasticactivityService $nonscholasticactivityService;
  public function __construct(NonscholasticactivityService $nonscholasticactivityService)
  {
    $this->nonscholasticactivityService = $nonscholasticactivityService;
    $this->middleware('auth:api', ['except' => []]);
  }

  function index(): Collection|JsonResponse
  {
    $lessons = Nonscholasticactivity::whereHas('lessons', function($query) {
      $query->where('creatorId', auth()->user()->id_User);
    })->get();
    if (count($lessons) > 0) {
      $handler = false;
    } else {
      $handler = response()->json(['message' => 'Activities not found'], 404);
    }

    if (!$handler) {
      return $lessons;
    } else {
      return $handler;
    }
  }

  function store(NonscholasticactivityStoreUpdateRequest $req): JsonResponse
  {
    $data = $req->validated();

    try {
      $handle = $this->nonscholasticactivityService->nonscholasticactivityErrorHandler($data);

      if (!$handle) {
        $nonscholasticactivity = $this->nonscholasticactivityService->create($data);
        return response()->json($nonscholasticactivity, 201);
      } else {
        return response()->json(['message' => 'Lesson already exists'], 409);
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Lesson adding failed'], 422);
    }
  }

  function destroy($id): JsonResponse
  {
    try {
      $activity = Nonscholasticactivity::find($id);

      $activity->delete();

      return response()->json(['success' => 'Activity type deleted']);

    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Activity deletion failed'], 422);
    }
  }
}
