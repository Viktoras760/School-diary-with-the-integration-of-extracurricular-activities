<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Lesson;
use App\Http\Controllers\AuthController;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function declineRegistrationRequest($id)
    {
        $role = (new AuthController)->authRole();
        if($role != 'System Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        $user = \App\Models\User::find($id);
        if ($user->confirmation != 'Unconfirmed')
        {
            return response()->json(['message' => 'User is already confirmed or declined'], 200);
        }
        User::where('id_User',$id)->update(['confirmation'=>'Declined']);
        return response()->json(['message' => 'Registration declined'], 200);
    }

    function getAllUsers(Request $request)
    {
        $role = (new AuthController)->authRole();
        if($role != 'System Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        if ($request->confirmation)
        {
            $users = \App\Models\User::where('user.confirmation','=',$request->confirmation)->get();
            return $users;
        }
        else if (\App\Models\User::where('user.confirmation','=',$request->confirmation)->get() == NULL)
        {
            return response()->json(['message' => 'Users with this filter are missing'], 404);
        }
        else if (!$request->confirmation && count($request->all()) > 1)
        {
            return response()->json(['message' => 'This filter is not implemented yet'], 404);
        }
        $users = \App\Models\User::all();
        return $users;
    }

    function getUser($id)
    {
        $role = (new AuthController)->authRole();
        if($role != 'System Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        $user = \App\Models\User::find($id);
        return $user;
    }

    function deleteUser($id)
    {
        $role = (new AuthController)->authRole();
        if($role != 'System Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        $user = \App\Models\User::find($id);

        if ($user == "") {
            return response()->json(['message' => 'User does not exist'], 404);
        }

        $user->delete();
        return response()->json(['success' => 'User deleted']);
    }

    function updateUser($id, Request $request)
    {
        $user = \App\Models\User::find($id);
        $role = (new AuthController)->authRole();
        if (($role == 'Teacher' || $role == 'Pupil') && $id != auth()->user()->id_User)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to update other users',
            ], 401);
        }
        else if ($role == 'School Administrator' && auth()->user()->fk_Schoolid_School != $user->fk_Schoolid_School)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to update users from this school',
            ], 401);
        }
        $user = \App\Models\User::find($id);
        if(!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $contains = Str::contains($request->email, '@');
        if (!$contains)
        {
            return response()->json(['failure' => 'Invalid email entered']);
        }
        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'personalCode' => $request->personalCode,
            'email' => $request->email,
            'grade' => $request->grade,
            'confirmation' => $request->confirmation,
            'fk_Schoolid_School' => $request->fk_Schoolid_School,
            'role' => $request->role
        ]);
        return response()->json(['success' => 'User updated successfully']);
    }

    function getSchoolUsers()
    {
        $role = (new AuthController)->authRole();
        /*if($role != 'System Administrator' || $role != 'School Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        if ($request->confirmation)
        {
            $users = \App\Models\User::where('user.confirmation','=',$request->confirmation)->get();
            return $users;
        }
        else if (\App\Models\User::where('user.confirmation','=',$request->confirmation)->get() == NULL)
        {
            return response()->json(['message' => 'Users with this filter are missing'], 404);
        }
        else if (!$request->confirmation && count($request->all()) > 1)
        {
            return response()->json(['message' => 'This filter is not implemented yet'], 404);
        }*/
        $user = auth()->user();
        $users = \App\Models\User::where('fk_Schoolid_School', '=', $user->fk_Schoolid_School)->where('role', '!=', 'System Administrator')->get();
        return $users;
    }



}
