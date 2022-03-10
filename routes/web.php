<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Allow;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/**
 * Verify User Authenticated
 */
Route::middleware([Allow::class])->group(function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('new_customer');

    Route::get('/load', [App\Http\Controllers\HomeController::class, 'loadFiles'])->name('load_files');
    
    Route::post('/load/save', [App\Http\Controllers\HomeController::class, 'saveFiles'])->name('save_files');

    Route::post('/customer/new', [App\Http\Controllers\CustomerController::class, 'newCustomer'])->name('new_customer');
    
    Route::post('/customer/single', [App\Http\Controllers\CustomerController::class, 'singleCustomer'])->name('single_customer');
    
    /**
     * Datables Endpoint
     */
    Route::get('/customer/api', [App\Http\Controllers\CustomerController::class, 'customerAPI'])->name('customer_API');
    
    Route::post('/customer/update', [App\Http\Controllers\CustomerController::class, 'updateCustomer'])->name('delete_customer');
    
    Route::post('/customer/delete', [App\Http\Controllers\CustomerController::class, 'deleteCustomer'])->name('update_customer');    

});
