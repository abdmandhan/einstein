<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseTaskController;
use App\Http\Controllers\CourseTypeController;
use App\Http\Controllers\DifficultyController;
use App\Http\Controllers\DiscussController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\LearningController;
use App\Http\Controllers\Student\LearningTaskController;
use App\Http\Controllers\Student\TeacherController;
use App\Http\Controllers\Student\TryOutController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TransactionController;
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

Route::group([
    // 'middleware'    => ['testing']
], function () {
    Route::get('app', [AppController::class, 'index']);
    Route::get('dashboard', [AppController::class, 'dashboard']);
    Route::get('options', [AppController::class, 'options']);
    Route::get('announcement', [AppController::class, 'announcement']);

    //admin
    Route::resource('user', UserController::class)->only(['index', 'store', 'destroy']);
    Route::resource('course', CourseController::class);
    Route::resource('course-content', CourseContentController::class)->only(['index', 'store', 'destroy', 'show']);
    Route::resource('transaction', TransactionController::class)->only(['index', 'update']);
    Route::resource('course-task', CourseTaskController::class);
    Route::resource('course-type', CourseTypeController::class)->only(['index', 'store', 'destroy']);
    Route::resource('grade', GradeController::class)->only(['index', 'store', 'destroy']);
    Route::resource('difficulty', DifficultyController::class)->only(['index', 'store', 'destroy']);
    Route::resource('position', PositionController::class)->only(['index', 'store', 'destroy']);
    Route::resource('transaction-status', TransactionStatusController::class)->only(['index', 'store', 'destroy']);
    Route::resource('discuss', DiscussController::class);

    //reply
    Route::post('discuss/replies', [DiscussController::class, 'storeReplies']);
    Route::delete('discuss/replies/{id}', [DiscussController::class, 'destroyReplies']);

    //student
    Route::resource('student', StudentController::class);
    Route::group(['prefix' => 's'], function () {
        Route::resource('learning', LearningController::class);
        Route::resource('learning-task', LearningTaskController::class);
        Route::resource('course', StudentCourseController::class);
        Route::resource('teacher', TeacherController::class);
        Route::resource('tryout', TryOutController::class);
        Route::get('payment/{id}', [StudentCourseController::class, 'payment']);
    });
});
