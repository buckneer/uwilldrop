<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\RideController;
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
Route::post('/ride/user', [RideController::class, 'doneUser'])->middleware('auth')->name('ride.user');
Route::post('/ride/driver', [RideController::class, 'doneDriver'])->middleware('auth')->name('ride.driver');
Route::post('/ride/rating', [RideController::class, 'addRating'])->middleware('auth')->name('ride.rating');
Route::resource('ride', RideController::class)->middleware('auth');


// AUTH
Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


