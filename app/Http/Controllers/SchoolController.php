<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\User;
use App\Http\Controllers\AuthController;

class SchoolController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:api', ['except' => []]);
    }
    function updateSchool($id, Request $request)
    {

        $state = (new AuthController)->loggedIn();
        if ($state = False)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $role = (new AuthController)->authRole();
        if($role != 'System Administrator' && $role != 'School Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }


        $school = \App\Models\School::find($id);

        if ($role == 'School Administrator' && $school->id_School != auth()->user()->fk_Schoolid_School)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to update this school',
            ], 401);
        }


        if(!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }
        $school->update([
            'name' => $request->name,
            'address' => $request->address,
            'pupilAmount' => $request->pupilAmount,
            'teacherAmount' => $request->teacherAmount
        ]);
        return response()->json(['success' => 'School updated successfully']);
    }

    function getSchool($id)
    {
        $role = (new AuthController)->authRole();
        $school = \App\Models\School::find($id);
        if($role != 'System Administrator' && $school->id_School != auth()->user()->fk_Schoolid_School)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        if ($role == 'School Administrator' && $school->id_School != auth()->user()->fk_Schoolid_School)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to get this school',
            ], 401);
        }
        if(!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }
        return $school;
    }

    function getAllSchools()
    {
        $role = (new AuthController)->authRole();
        if($role != 'System Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        $schools = \App\Models\School::all();

        if (!$schools) {
            return response()->json(['message' => 'Schools not found'], 404);
        }
        return $schools;
    }

    function addSchool(Request $req)
    {
        $role = (new AuthController)->authRole();
        if($role != 'System Administrator' )
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        $schools = \App\Models\School::where('name', '=', $req->input('name'))->get();
        $address = \App\Models\School::where('address', '=', $req->input('address'))->get();
        if(count($schools) > 0 || count($address) > 0)
        {
            return response()->json(['message' => 'School already exist'], 400);
        }

        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'pupilAmount' => 'required|integer|max:5000|min:0',
            'teacherAmount' => 'required|integer|max:1000|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $school = new School;
        $school->name= $req->input('name');
        $school->address= $req->input('address');
        $school->pupilAmount= $req->input('pupilAmount');
        $school->teacherAmount= $req->input('teacherAmount');
        $school->save();
        return $school;
    }

    function deleteSchool($id)
    {
        $role = (new AuthController)->authRole();
        if($role != 'System Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        $school = \App\Models\School::find($id);
        $user = \App\Models\User::where('user.fk_Schoolid_School','=',$id)->get();

        if ($school == "") {
            return response()->json(['message' => 'School does not exist'], 404);
        }
        else if (count($user) > 0)
        {
            return response()->json(['message' => 'School has users attached. Delete them first.'], 400);
        }
        $school->delete();
        return response()->json(['success' => 'School deleted']);
    }
}
