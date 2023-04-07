<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User routes
Route::group([
    'middleware' => 'api'
], function ($router) {
Route::get('user/{id}', [UserController::class, 'getUser']);
Route::patch('users/{id}', [UserController::class, 'declineRegistrationRequest']);
Route::get('users', [UserController::class, 'getAllUsers']);
Route::delete('users/{id}', [UserController::class, 'deleteUser']);
Route::put('users/{id}', [UserController::class, 'updateUser']);
Route::get('school_users', [UserController::class, 'getSchoolUsers']);
});

//School routes
Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::post('schools', [SchoolController::class, 'addSchool']);
    Route::put('schools/{id}', [SchoolController::class, 'updateSchool']);
    Route::get('schools/{id}', [SchoolController::class, 'getSchool']);
    Route::get('schools', [SchoolController::class, 'getAllSchools']);
    Route::delete('schools/{id}', [SchoolController::class, 'deleteSchool']);
    Route::get('test', [SchoolController::class, 'test']);

});

//Classroom routes
Route::group([
    'middleware' => 'api'
], function ($router) {
Route::post('schools/{idSchool}/classrooms', [ClassroomController::class, 'addClassroom']);
Route::put('schools/{idSchool}/classrooms/{idClassroom}', [ClassroomController::class, 'updateClassroom']);
Route::get('schools/{idSchool}/classrooms/{idClassroom}', [ClassroomController::class, 'getClassroom']);
Route::delete('schools/{idSchool}/classrooms/{idClassroom}', [ClassroomController::class, 'deleteClassroom']);
Route::get('schools/{idSchool}/classrooms', [ClassroomController::class, 'getClassroomBySchool']);
});

//Lesson routes
Route::group([
    'middleware' => 'api'
], function ($router) {
Route::get('schools/{idSchool}/classrooms/{idClassroom}/lessons/{id}', [LessonController::class, 'getLesson']);
Route::get('schools/{idSchool}/classrooms/{idClassroom}/lessons/', [LessonController::class, 'getLessons']);
Route::post('schools/{idSchool}/classrooms/{idClassroom}/lessons', [LessonController::class, 'addLesson']);
Route::post('schools/{idSchool}/classrooms/{idClassroom}/lessons/{id}', [LessonController::class, 'registerToLesson']);
Route::delete('schools/{idSchool}/classrooms/{idClassroom}/lessons/{id}', [LessonController::class, 'deleteLesson']);
Route::delete('user_lessons/{id}', [LessonController::class, 'unregisterFromLesson']);
Route::put('schools/{idSchool}/classrooms/{idClassroom}/lessons/{id}', [LessonController::class, 'updateLesson']);
Route::get('user_lessons/', [LessonController::class, 'getUserLessons']);
Route::get('teacher_lessons/', [LessonController::class, 'getTeachersLessons']);
});

//Auth routes
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('iat', [AuthController::class, 'login']);
    Route::post('users', [AuthController::class, 'register']);
    Route::get('tokens', [AuthController::class, 'logout']);
    Route::post('tokens', [AuthController::class, 'refresh']);
    Route::post('user', [AuthController::class, 'me']);
});
