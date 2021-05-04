<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

  
Route::get('/', function () {
    return redirect('login');
});

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout']);

//forgot password

Route::get('/forgot_password','auth\ForgotPassword@forgot');
Route::post('/forgot_password','auth\ForgotPassword@password');

//activate email

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});
