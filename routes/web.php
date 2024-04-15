<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JourneyController;
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



Route::resource('journey', JourneyController::class)->middleware('auth');

Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Route::get('/login', function () {
//    return view('auth.login');
//});
//
//Route::get('/register', function () {
//    return view('auth.register');
//});

