<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //only admin routes
    Route::middleware('role:' . UserModel::ROLE_ADMIN_ID)->group(function () {
        //users
        Route::get('/users', [UserController::class, 'listView'])
            ->name('users');
        Route::get('/users/add', [UserController::class, 'addView'])
            ->name('users.add');
        Route::get('/users/edit/{id}', [UserController::class, 'editView'])
            ->name('users.edit');
        Route::post('/users/update', [UserController::class, 'update'])
            ->name('users.update');
        Route::get('/users/delete/{id}', [UserController::class, 'delete'])
            ->name('users.delete');
        Route::get('/users/edit-password/{id}', [UserController::class, 'editPasswordView'])
            ->name('users.editPassword');
        Route::post('/users/update-password', [UserController::class, 'updatePassword'])
            ->name('users.updatePassword');
    });
});

require __DIR__.'/auth.php';
