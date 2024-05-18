<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth']);

Route::get('/journey', function() {
    return view('journey');
})->middleware(['auth'])->name('journey');

// JOURNEY

Route::resource('journey', JourneyController::class)->middleware('auth');

// RIDE
Route::get('/ride/active', [RideController::class, 'displayByUser'])->middleware(['auth'])->name('ride.display-by-user');
Route::post('/ride/user', [RideController::class, 'doneUser'])->middleware('auth')->name('ride.user');
Route::post('/ride/driver', [RideController::class, 'doneDriver'])->middleware('auth')->name('ride.driver');
Route::post('/ride/rating', [RideController::class, 'addRating'])->middleware('auth')->name('ride.rating');
Route::post('/ride/user/rating', [RideController::class, 'addUserRating'])->middleware('auth')->name('ride.user-rating');
Route::resource('ride', RideController::class)->middleware('auth');


// BILLING
Route::post('/billing/add', [BillingController::class, 'addFunds'])->middleware('auth')->name('billing.add');
Route::resource('billing', BillingController::class)->middleware('auth');

// TRANSACTION
Route::resource('transaction', TransactionController::class)->middleware('auth');


// AUTH
Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


