<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainLessonsStoreUpdateRequest;
use App\Http\Requests\SchoolStoreUpdateRequest;
use App\Models\Lesson;
use App\Models\MainLessons;
use App\Models\School;
use App\Services\MainLessonService;
use Illuminate\Http\Request;
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

  function show($id): JsonResponse
  {
    $mainLessons = MainLessons::with('classModel')->find($id);
    if ($mainLessons) {
      $handler = false;
    } else {
      $handler = response()->json(['message' => 'Subject not found'], 404);
    }

    if (!$handler) {
      return response()->json($mainLessons);
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

  function destroy($id): JsonResponse
  {
    try {
      $activity = MainLessons::find($id);

      $activity->delete();

      return response()->json(['success' => 'Lesson type deleted']);

    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'Lesson deletion failed'], 422);
    }
  }

  function getSubjectMarks($id, Request $request)
  {
    $subject = MainLessons::find($id);
    if ($subject) {
      $startDate = $request->startDate;
      $endDate = $request->endDate;

      $userMarks = Lesson::where('fk_mainLessonsid_mainLessons', '=', $id)
        ->where('lessonsStartingTime', '>', $startDate)
        ->where('lessonsEndingTime', '<', $endDate)
        ->whereHas('userLessons', function ($query) {
          $query->whereHas('user', function ($query) {
            $query->where('role', '!=', 2);
          });
        })
        ->with([
          'userLessons' => function ($query) {
            $query->whereHas('user', function ($query) {
              $query->where('role', '!=', 2);
            });
          },
          'userLessons.user'
        ])
        ->get();

      $transformedData = [];
      foreach($userMarks as $lesson) {
        foreach($lesson->userLessons as $userLesson) {
          $user = $userLesson->user;
          $fullName = $user->name . ' ' . $user->surname;
          if(!isset($transformedData[$fullName])) {
            $transformedData[$fullName] = [];
          }
          if($userLesson->mark !== null) {
            $transformedData[$fullName][$lesson->id_Lesson] = $userLesson->mark;
          }
        }
      }

      return $transformedData;
    } else {
      return response()->json(['message' => 'Subject not found'], 404);
    }
  }
}
