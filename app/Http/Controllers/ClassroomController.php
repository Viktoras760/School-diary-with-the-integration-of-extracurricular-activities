<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Http\Controllers\AuthController;

class ClassroomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    function addClassroom(Request $req, $idSchool)
    {
        $role = (new AuthController)->authRole();
        if($role != 'System Administrator' && $role != 'School Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }

        $school = \App\Models\School::find($idSchool);

        if ($role == 'School Administrator' && $school->id_School != auth()->user()->fk_Schoolid_School)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to add classroom at this school',
            ], 401);
        }
        $classroomEx = \App\Models\Classroom::where('fk_Schoolid_School', '=', $idSchool)->where('number', '=', $req->number)->get();

        if(!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }

        if (count($classroomEx) > 0)
        {
            return response()->json(['error' => 'Classroom with such number already exists in this school'], 404);
        }

        $validator = Validator::make($req->all(), [
            'number' => 'required|integer|max:100000|min:1',
            'pupilCapacity' => 'required|integer|max:500|min:1'

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }


        $classroom = new Classroom;
        $classroom->number= $req->input('number');
        $classroom->floorNumber= $req->input('floorNumber');
        $classroom->pupilCapacity= $req->input('pupilCapacity');
        $classroom->musicalEquipment= $req->input('musicalEquipment');
        $classroom->chemistryEquipment= $req->input('chemistryEquipment');
        $classroom->computers= $req->input('computers');
        $classroom->fk_Schoolid_School= $idSchool;
        $classroom->save();
        return $classroom;
    }

    function updateClassroom($idSchool, $idClassroom, Request $request)
    {

        $role = (new AuthController)->authRole();
        if($role != 'System Administrator' && $role != 'School Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }
        $school = \App\Models\School::find($idSchool);
        if ($role == 'School Administrator' && $school->id_School != auth()->user()->fk_Schoolid_School)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to update classrooms in this school',
            ], 401);
        }

        $classroom = \App\Models\Classroom::find($idClassroom);
        $SchoolsClassroom = \App\Models\Classroom::where('fk_Schoolid_School', '=', $idSchool)->where('id_Classroom', '=', $idClassroom)->get();
        if(!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }
        if(!$classroom) {
            return response()->json(['error' => 'Classroom not found'], 404);
        }
        if (count($SchoolsClassroom) < 1)
        {
            return response()->json(['error' => 'Classroom is on another floor. Cannot update'], 404);
        }
        $classroom->update([
            'number' => $request->number,
            'floorNumber' => $request->floorNumber,
            'pupilCapacity' => $request->pupilCapacity,
            'musicalEquipment' => $request->musicalEquipment,
            'chemistryEquipment' => $request->chemistryEquipment,
            'computers' => $request->computers
        ]);
        return response()->json(['success' => 'Classroom updated successfully']);
    }

    function getClassroom($idSchool, $idClassroom)
    {
        $role = (new AuthController)->authRole();
        $school = \App\Models\School::find($idSchool);
        if (($role == 'School Administrator' || $role == 'Teacher' || $role == 'Pupil') && $school->id_School != auth()->user()->fk_Schoolid_School)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to get classroom in this school',
            ], 401);
        }
        $classroom = \App\Models\Classroom::find($idClassroom);
        $SchoolsClassroom = \App\Models\Classroom::where('fk_Schoolid_School', '=', $idSchool)->where('id_Classroom', '=', $idClassroom)->get();
        if(!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }
        if(!$classroom) {
            return response()->json(['error' => 'Classroom not found'], 404);
        }
        if (count($SchoolsClassroom) < 1)
        {
            return response()->json(['error' => 'Selected school has no such classrooms'], 404);
        }
        return $classroom;
    }

    function deleteClassroom($idSchool, $idClassroom)
    {
        $role = (new AuthController)->authRole();
        if($role != 'System Administrator' && $role != 'School Administrator')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to do that',
            ], 401);
        }

        $school = \App\Models\School::find($idSchool);

        if ($role == 'School Administrator' && $school->id_School != auth()->user()->fk_Schoolid_School)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to delete classrooms in this school',
            ], 401);
        }

        $lesson = \App\Models\Lesson::where('fk_Classroomid_Classroom', '=', $idClassroom)->get();
        $classroom = \App\Models\Classroom::find($idClassroom);
        $SchoolsClassroom = \App\Models\Classroom::where('fk_Schoolid_School', '=', $idSchool)->where('id_Classroom', '=', $idClassroom)->get();
        if(!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }
        if(!$classroom) {
            return response()->json(['error' => 'Classroom not found'], 404);
        }
        if (count($SchoolsClassroom) < 1)
        {
            return response()->json(['error' => 'Selected school has no such classrooms'], 404);
        }
        if (count($lesson) > 1)
        {
            return response()->json(['error' => 'Classroom has lesson(s). Cannot delete', $lesson], 404);
        }

        $classroom->delete();

        return response()->json(['success' => 'Classroom deleted']);
    }

    function getClassroomBySchool($idSchool)
    {
        $school = \App\Models\School::find($idSchool);
        $role = (new AuthController)->authRole();
        $classrooms = \App\Models\Classroom::where('classroom.fk_Schoolid_School','=',$idSchool)->get();


        if (($role == 'School Administrator' || $role == 'Teacher' || $role == 'Pupil') && $school->id_School != auth()->user()->fk_Schoolid_School)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No rights to get classrooms in this school',
            ], 401);
        }

        if(!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }
        if (count($classrooms) < 1) {
            return response()->json(['message' => 'Classrooms not found'], 404);
        }
        return $classrooms;
    }

}


