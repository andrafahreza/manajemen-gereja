<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, "index"])->name('index');
Route::get('login', [AuthController::class, "login"])->name('login');
Route::post('login', [AuthController::class, "auth"])->name('login-auth');

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name("logout");

    Route::prefix("fakultas")->group(function() {
        Route::get('/', [FakultasController::class, 'index'])->name("fakultas");
        Route::post('/', [FakultasController::class, 'simpan'])->name("simpan-fakultas");
        Route::get('show/{id?}', [FakultasController::class, 'show'])->name("show-fakultas");
        Route::post('hapus', [FakultasController::class, 'hapus'])->name("hapus-fakultas");

        Route::prefix("petugas")->group(function() {
            Route::get('/list/{id?}', [FakultasController::class, 'petugas'])->name("petugas");
            Route::post('/simpan', [FakultasController::class, 'simpanPetugas'])->name("simpan-petugas");
            Route::get('show/{id?}', [FakultasController::class, 'showPetugas'])->name("show-petugas");
            Route::post('hapus', [FakultasController::class, 'hapusPetugas'])->name("hapus-petugas");

            Route::prefix("anggota")->group(function() {
                Route::get('/list/{id?}', [FakultasController::class, 'anggota'])->name("anggota");
                Route::post('/simpan', [FakultasController::class, 'simpanAnggota'])->name("simpan-anggota");
                Route::get('show/{id?}', [FakultasController::class, 'showAnggota'])->name("show-anggota");
                Route::post('hapus', [FakultasController::class, 'hapusAnggota'])->name("hapus-anggota");
            });
        });

    });
});
