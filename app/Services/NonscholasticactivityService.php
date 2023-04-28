<?php

namespace App\Services;

use App\Http\Controllers\AuthController;
use App\Models\Lesson;
use App\Models\MainLessons;
use App\Models\Nonscholasticactivity;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class NonscholasticactivityService
{

  public function nonscholasticactivityErrorHandler($data) {
    $exists = Lesson::where('creatorId', auth()->user()->id_User)
      ->whereHas('nonscholasticactivity', function ($query) use ($data) {
        $query->where('name', $data['name']);
      })
      ->exists();

    if ($exists) {
      return response()->json(['message' => 'Activity with such name and teacher is already created'], 404);
    } else {
      return false;
    }
  }

  public function update ($lessonId, $data): Nonscholasticactivity
  {
    $lesson = Nonscholasticactivity::find($lessonId);

    $lesson->update($data);

    return $lesson;
  }

  /**
   * @param $data
   * @return Nonscholasticactivity
   */
  public function create($data): Nonscholasticactivity
  {
    return Nonscholasticactivity::create($data);
  }
}
