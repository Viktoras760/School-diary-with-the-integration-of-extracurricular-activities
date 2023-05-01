<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Requests\UserUpdateRequest;
use App\Models\ClassModel;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Lesson;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
  private UserService $userService;
  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
    $this->middleware('auth:api', ['except' => []]);
  }

  function index(): Collection|JsonResponse|bool
  {
    try {
      $handle = $this->userService->userIndexErrorHandler();

      if (!$handle) {
        return User::with(['role1', 'confirmation'])->get();
      } else {
        return $handle;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function show($id)
  {
    try {
      $handle = $this->userService->userShowErrorHandler($id);

      if (!$handle) {
        return User::with(['role1', 'confirmation'])->find($id);
      } else {
        return $handle;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function destroy($id): JsonResponse|bool
  {
    try {
      $handle = $this->userService->userDestroyErrorHandler($id);

      if (!$handle) {
        $user = User::find($id);

        $user->delete();

        return response()->json(['success' => 'User deleted']);
      } else {
        return $handle;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function update($id, UserUpdateRequest $request): User|JsonResponse
  {
    $data = $request->validated();

    try {
      $handle = $this->userService->handleUpdateError($id);
      if (!$handle) {
        return $this->userService->update($data, $id);
      } else {
        return $handle;
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function getSchoolUsers()
  {
    try {
      $role = (new AuthController)->authRole();
      if($role != 'System Administrator' && $role != 'School Administrator')
      {
        return response()->json([
          'status' => 'error',
          'message' => 'No rights to do that',
        ], 401);
      }
      return User::where('fk_Schoolid_School', '=', auth()->user()->fk_Schoolid_School ?? null)->where('role', '!=', 4)->where('id_User', '!=', (auth()->user()->id_User ?? null))->with(['role1', 'confirmation'])->get();
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function getSchoolTeachers(Request $request)
  {
    $class = $request->class;
    try {
      $role = (new AuthController)->authRole();
      if($role != 'System Administrator' && $role != 'School Administrator')
      {
        return response()->json([
          'status' => 'error',
          'message' => 'No rights to do that',
        ], 401);
      }
      if ($class === '1') {
        return User::where('fk_Schoolid_School', '=', auth()->user()->fk_Schoolid_School ?? null)
          ->where('role', '=', 2)
          ->whereDoesntHave('teachingClass')
          ->get();
      } else {
        return User::where('fk_Schoolid_School', '=', auth()->user()->fk_Schoolid_School ?? null)->where('role', '=', 2)->get();
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function getUserCV($id): StreamedResponse|JsonResponse
  {
    try {
      $user = User::find($id);
      $pdfData = $user->cv;

      $headers = [
        'Content-Type' => 'application/pdf',
      ];

      return response()->streamDownload(function () use ($pdfData) {
        echo $pdfData;
      }, $headers);
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function getFreePupils($grade) {
    $grade = intval($grade);
    return User::where('fk_Schoolid_School', '=', auth()->user()->fk_Schoolid_School ?? null)
      ->where('role', '=', 1)
      ->where('confirmation', '=', 2)
      ->where('grade', '=', $grade)
      ->where('fk_Classid_Class', '=', null)
      ->get();
  }


  function attachToClass($id, $idClass): JsonResponse
  {
    try {
      $classModel = ClassModel::find($idClass);
      $allLessons = $classModel->getAllLessons();
      $user = User::find($id);

      if (!empty($allLessons)) {
        foreach ($allLessons as $lesson) {
          $lesson->users()->attach($user);
        }
      }

      $user->fk_Classid_Class = $idClass;
      $user->save();

      return response()->json(['message' => 'User successfully attached to class and its lessons'], 200);
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function detachFromClass($id): JsonResponse
  {
    try {
      $user = User::find($id);
      $idClass = $user->fk_Classid_Class;

      if ($idClass !== null) {
        $classModel = ClassModel::find($idClass);
        $allLessons = $classModel->getAllLessons();

        if (!empty($allLessons)) {
          foreach ($allLessons as $lesson) {
            $lesson->users()->detach($user);
          }
        }

        $user->fk_Classid_Class = null;
        $user->save();

        return response()->json(['message' => 'User successfully detached from class and its lessons'], 200);
      } else {
        return response()->json(['message' => 'User is not attached to any class'], 422);
      }
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => 'User detaching failed'], 422);
    }
  }

}
