<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicStoryController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:api', 'refresh.jwt', 'role:' . UserModel::ROLE_ADMIN_ID])->group(function () {
    Route::get('/stories', [TopicStoryController::class, 'listApi']);
    Route::get('/stories/{id}', [TopicStoryController::class, 'editApi']);
});


