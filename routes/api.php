<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseTaskController;
use App\Http\Controllers\CourseTypeController;
use App\Http\Controllers\DifficultyController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TransactionStatusController;
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

    Route::resource('user', UserController::class)->only(['index', 'store', 'destroy']);
    Route::resource('course', CourseController::class)->only(['index', 'store', 'destroy']);
    Route::resource('course-content', CourseContentController::class)->only(['index', 'store', 'destroy', 'show']);
    Route::resource('course-task', CourseTaskController::class)->only(['index', 'store', 'destroy', 'show']);
    Route::resource('course-type', CourseTypeController::class)->only(['index', 'store', 'destroy']);
    Route::resource('grade', GradeController::class)->only(['index', 'store', 'destroy']);
    Route::resource('difficulty', DifficultyController::class)->only(['index', 'store', 'destroy']);
    Route::resource('position', PositionController::class)->only(['index', 'store', 'destroy']);
    Route::resource('transaction-status', TransactionStatusController::class)->only(['index', 'store', 'destroy']);

    Route::get('table/{model}', TableController::class);
});
