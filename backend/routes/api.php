<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DelayController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTaskController;
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
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::get('user', [AuthController::class, 'user']);
});

Route::group([
    // 'middleware' => 'auth:api'
], function () {

    Route::get('users/{user}/tasks', [UserTaskController::class, 'index']);
    Route::get('users/{user}/tasks/current', [UserTaskController::class, 'current']);
    Route::get('users/{user}/tasks/pending', [UserTaskController::class, 'pending']);
    Route::apiResources([
        'users' => UserController::class,
        'tasks' => TaskController::class,
        'delays' => DelayController::class
    ]);
});
