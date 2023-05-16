<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('department')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::post('/create', [DepartmentController::class, 'store']);
    Route::put('/{department}', [DepartmentController::class, 'update']);
    Route::delete('/{department}', [DepartmentController::class, 'destroy']);
});
Route::prefix('curriculum')->group(function () {
    Route::get('/', [CurriculumController::class, 'index']);
    Route::post('/create', [CurriculumController::class, 'store']);
    Route::get('/{curriculum}', [CurriculumController::class, 'show']);
    Route::put('/{curriculum}', [CurriculumController::class, 'update']);
    Route::delete('/{curriculum}', [CurriculumController::class, 'destroy']);
});
Route::prefix('lesson')->group(function () {
    Route::get('/', [LessonController::class, 'index']);
    Route::post('/create', [LessonController::class, 'store']);
    Route::get('/{lesson}', [LessonController::class, 'show']);
    Route::put('/{lesson}', [LessonController::class, 'update']);
    Route::delete('/{lesson}', [LessonController::class, 'destroy']);
});
