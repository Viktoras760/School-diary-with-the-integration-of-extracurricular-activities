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
  public function update ($classId, $data): ClassModel
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
}
