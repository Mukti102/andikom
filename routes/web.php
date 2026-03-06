<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('peserta', PesertaController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('tools',ToolController::class);
    Route::get('/courses/{id}/pendaftar', [CourseController::class, 'pendaftar'])->name('course.pendaftar');
    Route::resource('pendaftaran', PendaftaranController::class);
    Route::get('/tagihan/{id}', [PendaftaranController::class, 'tagihan'])->name('tagihans');
    Route::resource('pembayaran', PembayaranController::class);
    Route::put('/pembayaran/verifikasi/{id}', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
