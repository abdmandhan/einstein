<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseTaskController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::group([], function () {
    Route::get('app', [AppController::class, 'index']);
    Route::get('options', [AppController::class, 'options']);

    Route::resource('user', UserController::class);
    Route::resource('course', CourseController::class);
    Route::resource('course-content', CourseContentController::class);
    Route::resource('course-task', CourseTaskController::class);
    // Route::post('course-content', [CourseController::class, 'createCourseContent']);

    Route::get('table/{model}', TableController::class);
});
