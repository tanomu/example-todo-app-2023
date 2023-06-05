<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'create']);

    Route::prefix('{id}')->group(function () {
        Route::put('/', [TaskController::class, 'update']);
        Route::put('/archive', [TaskController::class, 'archive']);
        Route::put('/unarchive', [TaskController::class, 'unarchive']);
    });
});

