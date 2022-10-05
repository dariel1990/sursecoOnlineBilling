<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('is_admin')->group(function () {
    Route::get('admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');
    Route::get('admin/userManagement', [App\Http\Controllers\AdminController::class, 'userManagement'])->name('admin.userManagement');
    Route::get('admin/userList', [App\Http\Controllers\UserController::class, 'userList']);
    Route::post('admin/user/create', [App\Http\Controllers\UserController::class, 'createUser']);
});

Route::middleware('is_user')->group(function () {
    Route::get('user/home', [App\Http\Controllers\HomeController::class, 'userHome'])->name('user.home');
});
