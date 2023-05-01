<?php

namespace App\Services;

use App\Http\Controllers\AuthController;
use App\Models\ClassModel;
use App\Models\MainLessons;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ClassService
{
  public function update($classId, $data): ClassModel
  {
    $class = ClassModel::find($classId);

    $class->update($data);

    return $class;
  }

  /**
   * @param $data
   * @return ClassModel
   */
  public function create($data): ClassModel
  {
    return ClassModel::create($data);
  }

  public function classErrorHandler($data)
  {
    $firstCharAsInt = intval($data['name'][0]);
    if ($firstCharAsInt != $data['grade']) {
      return response()->json(['error' => 'Class name does not correspond its grade'], 409);
    } else return false;
  }

  public function classDeletionErrorHandler($class)
  {
    if ($class->users()->count() > 0) {
      return response()->json(['error' => 'Class has pupil attached.'], 409);
    } else return false;
  }
}
