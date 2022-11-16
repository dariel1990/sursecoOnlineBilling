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

Auth::routes(['verify' => true]);

Route::middleware('is_admin')->group(function () {
    Route::get('admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');

    //Customer Page
    Route::get('admin/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('admin.customer.list');
    Route::get('admin/customerList', [App\Http\Controllers\CustomerController::class, 'customerList']);
    Route::get('admin/customerBillingDetails/{id}', [App\Http\Controllers\CustomerController::class, 'customerBillingDetails']);

});

Route::middleware('is_user')->group(function () {
    Route::get('home', [App\Http\Controllers\UserController::class, 'index'])->name('user.home')->middleware('verified');
    Route::post('payNow', [App\Http\Controllers\UserController::class, 'payNow'])->name('user.paynow')->middleware('verified');
    Route::get('payment/success/{billingId}', [App\Http\Controllers\UserController::class, 'paymentSuccess'])->name('user.success')->middleware('verified');
    Route::get('payment/failed', [App\Http\Controllers\UserController::class, 'paymentFailed'])->name('user.failed')->middleware('verified');
});


