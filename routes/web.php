<?php

use App\Http\Controllers\Admin\AdminMutasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\authController;
use App\Http\Controllers\Customer\appController;
use App\Http\Controllers\Customer\MutasiController;
use App\Http\Controllers\Customer\PesananController;
use App\Http\Controllers\halamanDepan\MenuController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [authController::class, 'showLogin'])->name('login');
    Route::post('/login', [authController::class, 'login'])->name('login.post');
    Route::get('/register', [authController::class, 'showRegister'])->name('register');
    Route::post('/register', [authController::class, 'register'])->name('register.post');
    Route::post('/logout', [authController::class, 'logout'])->name('logout');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// admin
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu/create', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // transaksi
    Route::get('/mutasi', [AdminMutasiController::class, 'index'])->name('mutasi.index');
    Route::get('/mutasi/{id}', [AdminMutasiController::class, 'show'])->name('mutasi.show');
});


// halaman utama
Route::get('/', [MenuController::class, 'customerIndex'])->name('customer.pesanan.menu');

Route::prefix('customer')->name('customer.')->group(function () {
    // backup
    // Route::get('/ealnya', [appController::class, 'index'])->name('app.menu');
    
    // Halaman Utama Keranjang
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::post('/pesanan/tambah/{id}', [PesananController::class, 'tambah'])->name('pesanan.tambah');
    Route::delete('/pesanan/hapus/{id}', [PesananController::class, 'hapus'])->name('pesanan.hapus');
    Route::post('/pesanan/clear', [PesananController::class, 'clear'])->name('pesanan.clear');
    
    // Proses Checkout
    Route::get('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');
    Route::post('/checkout', [PesananController::class, 'prosesCheckout'])->name('pesanan.prosesCheckout');
    
    // mutasi
    Route::get('/mutasi', [MutasiController::class, 'index'])->name('mutasi.index');
    Route::post('/transaksi/{id}/bayar', [MutasiController::class, 'bayar'])->name('transaksi.bayar');
    Route::post('/keranjang/update/{id}', [MutasiController::class, 'updateQty'])->name('keranjang.update');
    Route::post('/keranjang/hapus/{id}', [MutasiController::class, 'hapusAjax'])->name('keranjang.hapus-ajax');
});



















// tombol easy to use officialy from @egdrga on instagram
Route::get('/setup-app', function () {
    if (app()->environment('production')) {
        abort(403);
    }

    Artisan::call('migrate:fresh', ['--seed' => true]);
    Artisan::call('storage:link');

    return view('setup.success');
});
