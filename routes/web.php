<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;




Route::get('/', function() {
    return view('journey');
})->middleware(['auth'])->name('journey');




// AUTH
Route::middleware('auth')->group(function () {


    Route::middleware(['role:admin'])->group(function () {
        Route::post('/admin/ride/done', [AdminController::class, 'done'])->name('admin.ride.done');
        Route::post('/admin/ride/delete', [AdminController::class, 'deleteRide'])->name('admin.ride.delete');
        Route::post('/admin/journey/delete', [AdminController::class, 'deleteJourney'])->name('admin.journey.delete');
        Route::post('/admin/user/role', [AdminController::class, 'role'])->name('admin.user.role');
        Route::post('/admin/user/delete', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
        Route::get('/admin/rides', [AdminController::class, 'rides'])->name("admin.rides");
        Route::get('/admin/journeys', [AdminController::class, 'journeys'])->name('admin.journeys');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::resource('admin', AdminController::class);
    });

    // JOURNEY
    Route::get('/', [JourneyController::class, 'search'])->name('home');
    Route::get('journey/search', [JourneyController::class, 'search'])->name('journey.search');
    Route::get('journey/search/from', [JourneyController::class, 'autocompleteFrom'])->name('journey.autocompleteFrom');
    Route::post('journey/route', [JourneyController::class, 'route'])->name('journey.route');
    Route::get('journey/search/results', [JourneyController::class, 'filter'])->name('journey.filter');
    Route::resource('journey', JourneyController::class);

    // RIDE
    Route::get('/ride/active', [RideController::class, 'displayByUser'])->name('ride.display-by-user');
    Route::post('/ride/user', [RideController::class, 'doneUser'])->name('ride.user');
    Route::post('/ride/driver', [RideController::class, 'doneDriver'])->name('ride.driver');
    Route::post('/ride/rating', [RideController::class, 'addRating'])->name('ride.rating');
    Route::post('/ride/user/rating', [RideController::class, 'addUserRating'])->name('ride.user-rating');
    Route::resource('ride', RideController::class);

    // ROUTE
    Route::post('/route/share', [RouteController::class, 'share'])->name('route.share');

    // BILLING
    Route::post('/billing/add', [BillingController::class, 'addFunds'])->name('billing.add');
    Route::resource('billing', BillingController::class);

    // TRANSACTION
    Route::resource('transaction', TransactionController::class);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});




