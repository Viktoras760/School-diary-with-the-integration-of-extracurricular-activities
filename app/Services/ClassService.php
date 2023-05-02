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
    $schoolId = auth()->user()->fk_Schoolid_School ?? null;

    $users = User::where('fk_Schoolid_School', '=', $schoolId)->get();

    $classNames = $users->pluck('class1.name')->unique()->pluck('name')->toArray();

    if (in_array($data['name'], $classNames)) {
      return response()->json(['error' => 'Class with such name already exists in this school'], 409);
    }
    else if (strlen(strval($data['grade'])) == 2) {
      $firstTwoChars = substr($data['name'], 0, 2);
      if ($firstTwoChars != strval($data['grade'])) {
        return response()->json(['error' => 'Class name does not correspond to its grade'], 409);
      } else {
        return false;
      }
    } else {
      $firstCharAsInt = intval($data['name'][0]);
      if ($firstCharAsInt != $data['grade']) {
        return response()->json(['error' => 'Class name does not correspond its grade'], 409);
      } else return false;
    }
  }


  public function classDeletionErrorHandler($class)
  {
    if ($class->users()->count() > 0) {
      return response()->json(['error' => 'Class has pupil attached.'], 409);
    } else return false;
  }
}
