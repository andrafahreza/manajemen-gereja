<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalPelayanController;
use App\Http\Controllers\PengumumanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, "index"])->name('index');
Route::get('login', [AuthController::class, "login"])->name('login');
Route::post('login', [AuthController::class, "auth"])->name('login-auth');

Route::get('jadwal', [JadwalPelayanController::class, "index"])->name('jadwal');
Route::get('list-berita', [BeritaController::class, "index"])->name('berita');
Route::get('lihat-berita/{id}', [BeritaController::class, "lihat"])->name('lihat-berita');
Route::get('pengumuman', [PengumumanController::class, "index"])->name('pengumuman');

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

    Route::prefix("jadwal")->group(function() {
        Route::post('/', [JadwalPelayanController::class, 'simpan'])->name("simpan-jadwal");
        Route::get('show/{id?}', [JadwalPelayanController::class, 'show'])->name("show-jadwal");
        Route::post('hapus', [JadwalPelayanController::class, 'hapus'])->name("hapus-jadwal");
        Route::post('selesai', [JadwalPelayanController::class, 'selesai'])->name("selesai-jadwal");
        });

    Route::prefix("berita")->group(function() {
        Route::get('simpan/{id?}', [BeritaController::class, 'page'])->name("page-berita");
        Route::post('simpan', [BeritaController::class, 'simpan'])->name("simpan-berita");
        Route::post('hapus', [BeritaController::class, 'hapus'])->name("hapus-berita");
    });

    Route::prefix("pengumuman")->group(function() {
        Route::post('/', [PengumumanController::class, 'simpan'])->name("simpan-pengumuman");
        Route::get('show/{id?}', [PengumumanController::class, 'show'])->name("show-pengumuman");
        Route::post('hapus', [PengumumanController::class, 'hapus'])->name("hapus-pengumuman");
    });
});
