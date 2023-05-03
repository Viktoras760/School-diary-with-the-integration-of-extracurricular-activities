<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonStoreUpdateRequest;
use App\Models\ClassModel;
use App\Services\LessonService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\User;
use App\Models\School;
use App\Models\Classroom;
use Illuminate\Support\Carbon;
use App\Http\Controllers\AuthController;

class UserLessonController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => []]);
  }

  function EvaluateUsers($id, Request $request)
  {
    $users = $request->users;

    foreach($users as $user) {
      $us = User::find($user['id_User']);
      $userLesson = $us->userLessons()->where('fk_Lessonid_Lesson', '=', $user['pivot']['fk_Lessonid_Lesson'])->where('fk_Userid_User', '=', $user['pivot']['fk_Userid_User'])->first();
      if ($userLesson) {
        $userLesson->Attended = $user['attendance'] === 'attended' ? 1 : 2;
        $userLesson->mark = $user['marks'];
        $userLesson->comment = $user['comment'];
        $userLesson->save();
      }
    }
    return response()->json(['success' => 'Lesson successfully updated']);
  }
}
