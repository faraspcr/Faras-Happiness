<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PelangganController;

// ============================
// ROUTE TANPA MIDDLEWARE (PUBLIC)
// ============================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: ' . $param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'NIM saya: ' . $param1;
});

Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::post('question/store', [QuestionController::class, 'store'])
    ->name('question.store');

// ============================
// ROUTE LOGIN (PUBLIC)
// ============================
Route::get('auth', [AuthController::class, 'index'])->name('auth.index');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

// ============================
// ROUTE DENGAN MIDDLEWARE 'checkislogin' (PROTECTED)
// ============================
Route::group(['middleware' => ['checkislogin']], function () {

    // Dashboard Route
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // =============================================
    // ROUTE USER HANYA UNTUK SUPER ADMIN
    // =============================================
    Route::group(['middleware' => ['checkrole:Super Admin']], function () {
        Route::get('user', [UserController::class, 'index'])->name('user.index'); // ✅ 'user.index'
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user', [UserController::class, 'store'])->name('user.store');
        Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
        Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });
    // =============================================
    // ROUTE PELANGGAN UNTUK SEMUA ROLE YANG LOGIN
    // =============================================
    Route::resource('pelanggan', PelangganController::class);

    // Tambahan route untuk file upload
    Route::post('/pelanggan/{id}/upload-files', [PelangganController::class, 'uploadFiles'])
        ->name('pelanggan.upload-files');
    Route::delete('/pelanggan/{id}/delete-file/{fileId}', [PelangganController::class, 'deleteFile'])
        ->name('pelanggan.delete-file');

    // Logout
    Route::get('auth/logout', [AuthController::class, 'logout'])
        ->name('auth.logout');
});
