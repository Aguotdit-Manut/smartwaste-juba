<?php


use App\Http\Controllers\Collector\LocationController;
use App\Http\Controllers\Collector\DashboardController as CollectorDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Resident\PickupRequestController;
use App\Http\Controllers\Resident\MyRequestController;
use App\Http\Controllers\Collector\JobController as CollectorJobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');
});

Route::middleware('auth')->group(function () {

    Route::middleware('role:collector')->prefix('collector')->name('collector.')->group(function () {

    Route::get('/jobs', [CollectorJobController::class, 'index'])
        ->name('jobs.index');

    Route::get('/jobs/{pickupRequest}', [CollectorJobController::class, 'show'])
        ->name('jobs.show');

    Route::post('/jobs/{pickupRequest}/accept', [CollectorJobController::class, 'accept'])
        ->name('jobs.accept');

    Route::post('/jobs/{pickupRequest}/reject', [CollectorJobController::class, 'reject'])
        ->name('jobs.reject');

    Route::post('/jobs/{pickupRequest}/start', [CollectorJobController::class, 'start'])
        ->name('jobs.start');

    Route::post('/jobs/{pickupRequest}/collect', [CollectorJobController::class, 'collect'])
        ->name('jobs.collect');

    Route::post('/jobs/{pickupRequest}/complete', [CollectorJobController::class, 'complete'])
        ->name('jobs.complete');
        
    Route::post('/location', [LocationController::class, 'store'])
    ->name('location.store');

    Route::post('/location/availability', [LocationController::class, 'toggleAvailability'])
        ->name('location.availability');
});
   
Route::middleware('role:resident')
    ->prefix('resident')
    ->name('resident.')
    ->group(function () {

        Route::get(
             '/pickups/{pickupRequest}/tracking',
               [MyRequestController::class, 'tracking']
                    )->name('requests.tracking');
                    
        Route::get('/pickups', [MyRequestController::class, 'index'])
            ->name('requests.index');

        Route::get('/pickups/{pickupRequest}', [MyRequestController::class, 'show'])
            ->name('requests.show');

        Route::get('/pickups/create', [PickupRequestController::class, 'create'])
            ->name('pickups.create');

        Route::post('/pickups', [PickupRequestController::class, 'store'])
            ->name('pickups.store');

        Route::get('/pickups/{pickupRequest}/review', [PickupRequestController::class, 'review'])
            ->name('pickups.review');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/resident/dashboard', [DashboardController::class, 'resident'])
        ->middleware('role:resident')
        ->name('resident.dashboard');

    Route::get('/collector/dashboard', [CollectorDashboardController::class, 'index'])
    ->name('collector.dashboard');

    Route::get('/hub/dashboard', [DashboardController::class, 'hub'])
        ->middleware('role:hub')
        ->name('hub.dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});