<?php

use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\QrLocationController;
use App\Http\Controllers\Admin\QrTokenController;
use App\Http\Controllers\Admin\QrDisplayController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin -> dashboard admin, siswa -> diarahkan ke /siswa/dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('classes', ClassRoomController::class);
    Route::resource('students', StudentController::class);
    Route::resource('qr-locations', QrLocationController::class);
    Route::post('/qr-tokens/generate', [QrTokenController::class, 'generate'])->name('qr-tokens.generate');
    Route::get('/qr-tokens/{qrToken}/display', [QrDisplayController::class, 'show'])->name('qr-tokens.display');
    Route::patch('/qr-tokens/{qrToken}/toggle', [QrTokenController::class, 'toggle'])->name('qr-tokens.toggle');
    });

    Route::get('/scan/{token}', function ($token) {
    return 'Token QR: ' . $token;
    })->name('qr.scan');

require __DIR__.'/auth.php';