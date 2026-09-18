<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | SuperAdmin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:SuperAdmin')->group(function () {

        Route::resource('companies', CompanyController::class);

    });


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Admin')->group(function () {

        Route::get('/admin', function () {
            return 'Admin Area';
        })->name('admin.dashboard');

    });


    /*
    |--------------------------------------------------------------------------
    | Member Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Member')->group(function () {

        Route::get('/member', function () {
            return 'Member Area';
        })->name('member.dashboard');

    });


    /*
    |--------------------------------------------------------------------------
    | Sales Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Sales')->group(function () {

        Route::get('/sales', function () {
            return 'Sales Area';
        })->name('sales.dashboard');

    });


    /*
    |--------------------------------------------------------------------------
    | Manager Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Manager')->group(function () {

        Route::get('/manager', function () {
            return 'Manager Area';
        })->name('manager.dashboard');

    });

});