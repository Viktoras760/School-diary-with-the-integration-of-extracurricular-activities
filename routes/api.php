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
  Route::get('school_users/', [UserController::class, 'getSchoolUsers']);
  Route::get('users/{id}/CV', [UserController::class, 'getUserCV']);
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
  Route::delete('user_lessons/{id}', [LessonController::class, 'unregisterFromLesson']);
  Route::get('user_lessons/', [LessonController::class, 'getUserLessons']);
  Route::get('teacher_lessons/', [LessonController::class, 'getTeachersLessons']);
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
