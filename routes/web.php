<?php

use App\Http\Controllers\CustomLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [CustomLoginController::class, 'index'])->name('login');
Route::post('/admin/login', [CustomLoginController::class, 'authenticate'])->name('authenticate');


// Google OAuth routes
Route::get('/auth/google', [CustomLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [CustomLoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
