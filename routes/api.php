<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\MainLessonsController;
use App\Http\Controllers\NonscholasticactivityController;
use App\Http\Controllers\UserLessonController;
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
  Route::get('school_users/', [UserController::class, 'getSchoolUsers']);
  Route::get('school_teachers/', [UserController::class, 'getSchoolTeachers']);
  Route::get('users/{id}/cv', [UserController::class, 'getUserCV']);
  Route::get('free_pupils/{grade}', [UserController::class, 'getFreePupils']);
  Route::put('user/{id}/class/{idClass}', [UserController::class, 'attachToClass']);
  Route::put('user/{id}/', [UserController::class, 'detachFromClass']);
  $router->apiResource('users', UserController::class);
});

//School routes
Route::group([
    'middleware' => 'api'
], function ($router) {
  $router->apiResource('schools', SchoolController::class);
});

//Classroom routes
Route::group([
    'middleware' => 'api'
], function ($router) {
  $router->apiResource('schools/{idSchool}/classrooms', ClassroomController::class);
});

//Lesson routes
Route::group([
    'middleware' => 'api'
], function ($router) {
  Route::post('schools/{idSchool}/classrooms/{idClassroom}/lessons/{id}', [LessonController::class, 'registerToLesson']);
  Route::post('schools/{idSchool}/classrooms/{idClassroom}/lessons/{id}/course', [LessonController::class, 'registerToCourse']);
  Route::delete('user_lessons/{id}', [LessonController::class, 'unregisterFromLesson']);
  Route::delete('classroom/{idClassroom}/user_lessons/{id}/course', [LessonController::class, 'unregisterFromCourse']);
  Route::get('user_lessons/', [LessonController::class, 'getUserLessons']);
  Route::get('user_lessons/custom', [LessonController::class, 'getUserLessonsCustom']);
  Route::get('lesson_users/{id}', [LessonController::class, 'getLessonUsers']);
  Route::get('teacher_lessons/', [LessonController::class, 'getTeachersLessons']);
  Route::post('custom_lessons/', [LessonController::class, 'addCustomActivity']);
  Route::get('lesson/{id}', [LessonController::class, 'getLesson']);
  $router->apiResource('schools/{idSchool}/classrooms/{idClassroom}/lessons', LessonController::class);
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

//Main lessons
Route::group([
  'middleware' => 'api',
], function ($router) {
  $router->apiResource('mainlessons', MainLessonsController::class);
});

//Nonscholastic activities
Route::group([
  'middleware' => 'api',
], function ($router) {
  $router->apiResource('nonscholastic', NonscholasticactivityController::class);
});

//Classes
Route::group([
  'middleware' => 'api',
], function ($router) {
  $router->apiResource('class', ClassController::class);
});

//UserLesson
Route::group([
  'middleware' => 'api',
], function ($router) {
  Route::put('/lesson/{id}/users/', [UserLessonController::class, 'EvaluateUsers']);
});
