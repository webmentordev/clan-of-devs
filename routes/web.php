<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;
Route::livewire('/', "home")->name('home');
Route::livewire('/setup', "setup")->name('setup');

Route::middleware(['guest'])->group(function(){
    // Authentication routes
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Password reset routes
    Route::get('/forgot-password', [PasswordController::class, 'index'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'request'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordController::class, 'reset'])->middleware('guest')->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'update'])->middleware('guest')->name('password.update');
});

Route::middleware(['auth'])->group(function(){
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});