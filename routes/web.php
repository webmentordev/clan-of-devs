<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

Route::livewire('/', "home")->name('home');

Route::middleware(['guest'])->group(function(){
    // Authentication routes
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);

    // Google Auth
    Route::post('/google/auth/redirect', [AuthController::class, 'google_login'])->name('google.redirect');
    Route::get('/google/oauth/callback-url', [AuthController::class, 'google_auth']);

    // Password reset routes
    Route::get('/forgot-password', [PasswordController::class, 'index'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'request'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordController::class, 'reset'])->middleware('guest')->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'update'])->middleware('guest')->name('password.update');
});


Route::middleware(['auth'])->group(function(){
    // Workspace Routes (post authentication)
    Route::livewire('/workspaces/{workspace}', "auth.workspaces")->name("workspaces");
    Route::livewire('/workspaces/{workspace}/channel/{channel}', "auth.text-channel")->name("text.channel");

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});