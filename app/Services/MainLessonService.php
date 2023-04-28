<?php

namespace App\Services;

use App\Http\Controllers\AuthController;
use App\Models\MainLessons;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class MainLessonService
{
  public function mainLessonErrorHandler($data) {
    $exists = MainLessons::where('lessonsType', '=', $data['lessonsType'])
      ->where('fk_Classid_Class', '=', $data['fk_Classid_Class'])
      ->exists();
    if ($exists) {
      return response()->json(['message' => 'Such lesson for selected class is already created'], 409);
    } else {
      return false;
    }
  }
  public function update ($lessonId, $data): MainLessons
  {
    $lesson = MainLessons::find($lessonId);

    $lesson->update($data);

    return $lesson;
  }

  /**
   * @param $data
   * @return MainLessons
   */
  public function create($data): MainLessons
  {
    return MainLessons::create($data);
  }
}
