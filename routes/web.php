<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::livewire('/', "home")->name('home');

// Authentication Projects
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);

// Workspace Routes (post authentication)
Route::livewire('/workspaces/{workspace}', "auth.workspaces")->name("workspaces");
Route::livewire('/workspaces/{workspace}/channel/{channel}', "auth.text-channel")->name("text.channel");