<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ForgotPassword;
use Illuminate\Support\Facades\Route;

  
Route::get('/', function () {
    return redirect('login');
});

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout']);

//forgot password

//Route::get('/forgot_password','auth\ForgotPassword@forgot');
Route::get('/forgot_password', [ForgotPassword::class, 'forgot'])->name('forgot');
//Route::post('/forgot_password','auth\ForgotPassword@password');
Route::post('/forgot_password', [ForgotPassword::class, 'password'])->name('password');
//activate email

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});
