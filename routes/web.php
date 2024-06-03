<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, "index"])->name('index');
Route::get('login', [AuthController::class, "login"])->name('login');
Route::post('login', [AuthController::class, "auth"])->name('login-auth');

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name("logout");
});
