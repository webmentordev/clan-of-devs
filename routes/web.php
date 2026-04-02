<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::livewire('/', "home")->name('home');

// Workspace Routes (post authentication)
Route::livewire('/workspaces/{workspace}', "auth.workspaces")->name("workspaces");
Route::livewire('/workspaces/{workspace}/channel/{channel}', "auth.text-channel")->name("text.channel");

Route::middleware(['guest'])->group(function(){
    // Authentication Projects
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);

    // Google Auth
    Route::post('/google/auth/redirect', [AuthController::class, 'google_login'])->name('google.redirect');
    Route::get('/google/oauth/callback-url', [AuthController::class, 'google_auth']);
});


Route::middleware(['auth'])->group(function(){
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});