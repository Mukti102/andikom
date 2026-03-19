<?php

use App\Http\Controllers\AnnouncmentController;
use App\Http\Controllers\CertificateTemplateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $courses = Course::all();
    return view('welcome', compact('courses'));
});




Route::middleware('auth', 'role:admin,owner')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('peserta', PesertaController::class)->except('update');
    Route::patch('/peserta/{id}/verifikasi', [PesertaController::class, 'verifikasi'])->name('peserta.verifikasi');
    Route::get('/peserta-export', [PesertaController::class, 'exportPDF'])->name('peserta.export');
    Route::resource('courses', CourseController::class);
    Route::resource('tools', ToolController::class);
    Route::get('/courses/{id}/pendaftar', [CourseController::class, 'pendaftar'])->name('course.pendaftar');
    Route::resource('pendaftaran', PendaftaranController::class)->except('store');
    Route::get('/tagihan/{id}', [PendaftaranController::class, 'tagihan'])->name('tagihans');
    Route::resource('pembayaran', PembayaranController::class);
    Route::put('/pembayaran/verifikasi/{id}', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
    Route::resource('jadwal', JadwalController::class);
    Route::get('/pengumuman', [AnnouncmentController::class, 'index'])->name('announcment.index');
    Route::post('/pengumuman', [AnnouncmentController::class, 'store'])->name('announcment.store');
    Route::delete('/pengumuman/{id}', [AnnouncmentController::class, 'destroy'])->name('announcment.destroy');

    Route::get('/certificate-templates', [CertificateTemplateController::class, 'index'])->name('certificate-template.index');
    Route::post('/certificate-templates', [CertificateTemplateController::class, 'store'])->name('certificate-template.store');
    Route::get('/certificate-templates/{id}/builder', [CertificateTemplateController::class, 'builder'])->name('certificate-template.builder');
    Route::post('/certificate-templates/{id}/builder/save', [CertificateTemplateController::class, 'save'])->name('certificate-template.builder.save');
    Route::delete('/certificate-templates/{id}', [CertificateTemplateController::class, 'delete'])->name('certificate-template.delete');
});



Route::middleware(['auth', 'role:tutor'])->group(function () {
    Route::get('/pembelajaran/{pendaftar_id}/peserta/toogle', [PembelajaranController::class, 'toogle'])->name('pembelajaran.peserta.toogle');
    Route::get('/pembelajaran/{course_id}/materi/create', [MateriController::class, 'create'])->name('pembelajaran.materi.create');
    Route::get('/pembelajaran/{course_id}/materi/edit', [MateriController::class, 'edit'])->name('pembelajaran.materi.edit');
    Route::post('/pembelajaran/{course_id}/materi/store', [MateriController::class, 'store'])->name('pembelajaran.materi.store');
    Route::put('/pembelajaran/{course_id}/materi/store', [MateriController::class, 'update'])->name('pembelajaran.materi.update');
    Route::delete('/pembelajaran/{id}/materi/destroy', [MateriController::class, 'destroy'])->name('pembelajaran.materi.destroy');
});


Route::middleware(['auth', 'role:admin,owner'])->group(function () {
    Route::get('arus-kas', [ExpenseController::class, 'index'])->name('cash.flow');
    Route::post('arus-kas', [ExpenseController::class, 'store'])->name('cash.flow.store');
    Route::delete('arus-kas/{id}', [ExpenseController::class, 'destroy'])->name('cash.flow.destroy');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
});


Route::middleware('auth')->group(function () {
    Route::resource('pendaftaran', PendaftaranController::class)->only('store');
    Route::post('/pembelajaran/nilai', [NilaiController::class, 'store'])->name('pembelajaran.nilai.store');
    Route::patch('/pembelajaran/certificate/{id}', [NilaiController::class, 'store_certificate'])->name('pembelajaran.nilai.store.certificate');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/user/courses', [CourseController::class, 'user'])->name('user.courses.index');
    Route::get('/user/courses/{id}', [CourseController::class, 'show'])->name('user.courses.show');
    Route::get('/user/tagihan/{id}', [PendaftaranController::class, 'userTagihan'])->name('user.tagihan');
    Route::get('/pembelajaran', [PembelajaranController::class, 'index'])->name('pembelajaran.index');
    Route::get('/pembelajaran/{id}/peserta', [PembelajaranController::class, 'peserta'])->name('pembelajaran.peserta');
    Route::get('/pembelajaran/{course_id}/materi', [MateriController::class, 'index'])->name('pembelajaran.materi.index');
    Route::get('/pembelajaran/{course_id}/nilai', [NilaiController::class, 'index'])->name('pembelajaran.nilai.index');

    Route::resource('peserta', PesertaController::class)->only('update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
