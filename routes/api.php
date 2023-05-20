<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LessonController;
use Illuminate\Http\Request;
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

Route::get('/unauthorized', function () {
    return response()->json([
        'status' => false,
        'message' => 'Unauthorized'
    ], 401);
})->name('unauthorized');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::prefix('department')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::post('/create', [DepartmentController::class, 'store']);
    Route::put('/{department}', [DepartmentController::class, 'update']);
    Route::delete('/{department}', [DepartmentController::class, 'destroy']);
});
Route::get('/get-all-curriculum', [CurriculumController::class, 'index']);
Route::get('/get-all-lesson', [LessonController::class, 'index']);
Route::middleware(['auth:api'])->group(function () {
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/get-all-user', [AuthController::class, 'getAllUser']);
    Route::put('/user/{user}', [AuthController::class, 'updateUser']);
    Route::delete('/user/{user}', [AuthController::class, 'deleteUser']);
    Route::prefix('curriculum')->group(function () {
        Route::post('/create', [CurriculumController::class, 'store']);
        Route::put('/{curriculum}', [CurriculumController::class, 'update']);
        Route::delete('/{curriculum}', [CurriculumController::class, 'destroy']);
    });
    Route::prefix('lesson')->group(function () {
        Route::post('/create', [LessonController::class, 'store']);
        Route::put('/{lesson}', [LessonController::class, 'update']);
        Route::delete('/{lesson}', [LessonController::class, 'destroy']);
    });
});
Route::get('curriculum/{curriculum}', [CurriculumController::class, 'show']);
Route::get('lesson/{lesson}', [LessonController::class, 'show']);
