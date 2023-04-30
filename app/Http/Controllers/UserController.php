<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Requests\UserUpdateRequest;
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
        return User::all();
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
        return User::find($id);
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
      return User::where('fk_Schoolid_School', '=', auth()->user()->fk_Schoolid_School ?? null)->where('role', '!=', 4)->get();
    } catch (QueryException $e) {
      return response()->json(['error' => $e->getMessage(), 'message' => trans('global.failed')], 422);
    }
  }

  function getSchoolTeachers()
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
      return User::where('fk_Schoolid_School', '=', auth()->user()->fk_Schoolid_School ?? null)->where('role', '=', 2)->get();
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

}
