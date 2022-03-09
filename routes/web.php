<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('new_customer');

Route::post('/customer/new', [App\Http\Controllers\CustomerController::class, 'newCustomer'])->name('new_customer');

Route::post('/customer/single', [App\Http\Controllers\CustomerController::class, 'singleCustomer'])->name('single_customer');

Route::get('/customer/api', [App\Http\Controllers\CustomerController::class, 'customerAPI'])->name('customer_API');

Route::post('/customer/update', [App\Http\Controllers\CustomerController::class, 'updateCustomer'])->name('delete_customer');

Route::post('/customer/delete', [App\Http\Controllers\CustomerController::class, 'deleteCustomer'])->name('update_customer');
