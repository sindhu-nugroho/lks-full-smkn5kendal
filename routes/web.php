<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController; // WAJIB ADA BARIS INI
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

// Halaman Form Login (Berikan nama 'login' pada GET method)
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirect halaman utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Proteksi dengan Middleware Auth
Route::middleware(['auth'])->group(function () {
    // ... isi route lainnya tetap sama
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransactionController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/store', [TransactionController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/kembali/{id}', [TransactionController::class, 'returnBook'])->name('transaksi.return');
    Route::get('/transaksi/{id}', [TransactionController::class, 'show'])->name('transaksi.show');

    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('buku', BookController::class);
        Route::resource('users', UserController::class);
        Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
        Route::post('/laporan/cetak', [ReportController::class, 'generatePDF'])->name('laporan.cetak');
    });
});