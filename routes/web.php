<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShortUrlController;







/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Login page
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Login submit
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


    Route::resource(
        'short-urls',
        ShortUrlController::class
    )->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Invitation Accept
    |--------------------------------------------------------------------------
    |
    | User invitation token ke through accept karega.
    |
    */

    Route::get(
        '/invitations/accept/{token}',
        [InvitationController::class, 'accept']
    )->name('invitations.accept');


    /*
    |--------------------------------------------------------------------------
    | SuperAdmin Routes
    |--------------------------------------------------------------------------
    |
    | Sirf SuperAdmin:
    | - Companies manage karega
    | - Users manage karega
    |
    */

    Route::middleware('role:SuperAdmin')->group(function () {

        // Company CRUD
        Route::resource('companies', CompanyController::class);
        Route::resource('users', UserController::class);
    });


    /*
    |--------------------------------------------------------------------------
    | Invitation Routes
    |--------------------------------------------------------------------------
    |
    | SuperAdmin OR Admin invitation manage kar sakte hain.
    |
    */

    Route::middleware('role:SuperAdmin|Admin')->group(function () {

        Route::resource('invitations', InvitationController::class)
            ->only([
                'index',
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ]);
    });


    /*
    |--------------------------------------------------------------------------
    | Admin Area
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Admin')->group(function () {

        Route::get('/admin', function () {
            return 'Admin Area';
        })->name('admin.dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | Member Area
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Member')->group(function () {

        Route::get('/member', function () {
            return 'Member Area';
        })->name('member.dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | Sales Area
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Sales')->group(function () {

        Route::get('/sales', function () {
            return 'Sales Area';
        })->name('sales.dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | Manager Area
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Manager')->group(function () {

        Route::get('/manager', function () {
         
        })->name('manager.dashboard');
    });
});
