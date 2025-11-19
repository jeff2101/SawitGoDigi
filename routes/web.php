<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agen\SupirController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AuthController; // Untuk admin login
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agen\AgenController;
use App\Http\Controllers\Agen\HargaJualController;
use App\Http\Controllers\Petani\PetaniController;
use App\Http\Controllers\Petani\LahanController;
use App\Http\Controllers\Admin\AgenController as AdminAgenController;
use App\Http\Controllers\Admin\UsahaController;
use App\Http\Controllers\Agen\PetaniController as AgenPetaniController;
use App\Http\Controllers\Supir\SupirController as SupirSupirController;
use App\Http\Controllers\Petani\PemesananPetaniController;
use App\Http\Controllers\Agen\PemesananAgenController;
use App\Http\Controllers\Supir\PemesananSupirController;
use App\Http\Controllers\Agen\TransaksiController;
use App\Http\Controllers\Agen\DataPetaniController;
use App\Http\Controllers\Agen\LaporanController;
use App\Http\Controllers\Supir\TrackRecordController;
use App\Http\Controllers\Petani\TransaksiPetaniController;
use App\Http\Controllers\Petani\HargaJualPetaniController;
use App\Http\Controllers\Petani\SupirPetaniController;
use App\Http\Controllers\Agen\TrackingController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\FaqController;

// ==================
// HALAMAN UTAMA
// ==================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ==================
// ADMIN AUTH ROUTES
// ==================
Route::middleware('trusted.device')->prefix('admin')->group(function () {  // ✅ TAMBAHKAN INI
    // Login manual admin
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Login via Google untuk admin
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogleAdmin'])
        ->name('google.login.admin');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallbackAdmin']);
});

// ==================
// ADMIN ROUTES
// ==================
Route::middleware(['admin', 'otp.verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/petanis', [AdminController::class, 'petanis'])->name('petanis');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile/delete', [AdminController::class, 'destroy'])->name('profile.delete');

    // CRUD AGEN (Sekarang pakai AgenController)
    Route::get('/agens', [AdminAgenController::class, 'index'])->name('agens.index');
    Route::get('/agens/create', [AdminAgenController::class, 'create'])->name('agens.create');
    Route::post('/agens', [AdminAgenController::class, 'store'])->name('agens.store');
    Route::get('/agens/{id}/edit', [AdminAgenController::class, 'edit'])->name('agens.edit');
    Route::put('/agens/{id}', [AdminAgenController::class, 'update'])->name('agens.update');
    Route::delete('/agens/{id}', [AdminAgenController::class, 'destroy'])->name('agens.destroy');

    // CRUD USAHA (mengacu pada AgenController)
    Route::get('/usahas', [UsahaController::class, 'index'])->name('usahas.index');
    Route::get('/usahas/create', [UsahaController::class, 'create'])->name('usahas.create');
    Route::post('/usahas', [UsahaController::class, 'store'])->name('usahas.store');
    Route::get('/usahas/{id}/edit', [UsahaController::class, 'edit'])->name('usahas.edit');
    Route::put('/usahas/{id}', [UsahaController::class, 'update'])->name('usahas.update');
    Route::delete('/usahas/{id}', [UsahaController::class, 'destroy'])->name('usahas.destroy');

    // CRUD About
    Route::get('/about', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('/about', [AboutController::class, 'update'])->name('about.update');

    //CRUD Visi Misi
    Route::get('/visi-misi', [VisiMisiController::class, 'edit'])->name('visimisi.edit');
    Route::put('/visi-misi', [VisiMisiController::class, 'update'])->name('visimisi.update');

    // Fitur - CRUD lengkap kecuali show
    Route::resource('features', FeatureController::class)->except(['show']);

    Route::resource('gallery-items', GalleryItemController::class)->except(['show']);

    Route::resource('faqs', FaqController::class)->except(['show']);
});


// ==================
// PETANI REGISTRATION
// ==================
Route::get('/register', [RegisterController::class, 'showForm'])->name('user.register');
Route::post('/register', [RegisterController::class, 'register'])->name('user.register.submit');

Route::middleware(['web'])->group(function () {
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])
        ->name('google.login');

    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
});

// ==================
// USER AUTH (Petani & Agen , Supir login)
// ==================
Route::middleware('trusted.device')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('user.login.submit');
});
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');


// ==================
// AGEN ROUTES
// ==================

Route::middleware(['auth:agen', 'otp.verified'])->prefix('agen')->name('agen.')->group(function () {
    Route::get('/dashboard', [AgenController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AgenController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AgenController::class, 'updateProfile'])->name('profile.update');

    // CRUD Petani untuk Agen
    Route::get('/petanis', [AgenPetaniController::class, 'index'])->name('petanis.index');
    Route::get('/petanis/create', [AgenPetaniController::class, 'create'])->name('petanis.create');
    Route::post('/petanis', [AgenPetaniController::class, 'store'])->name('petanis.store');
    Route::get('/petanis/{id}/edit', [AgenPetaniController::class, 'edit'])->name('petanis.edit');
    Route::put('/petanis/{id}', [AgenPetaniController::class, 'update'])->name('petanis.update');
    Route::delete('/petanis/{id}', [AgenPetaniController::class, 'destroy'])->name('petanis.destroy');

    // CRUD Supir untuk Agen
    Route::get('/supirs', [SupirController::class, 'index'])->name('supirs.index');
    Route::get('/supirs/create', [SupirController::class, 'create'])->name('supirs.create');
    Route::post('/supirs', [SupirController::class, 'store'])->name('supirs.store');
    Route::get('/supirs/{id}/edit', [SupirController::class, 'edit'])->name('supirs.edit');
    Route::put('/supirs/{id}', [SupirController::class, 'update'])->name('supirs.update');
    Route::delete('/supirs/{id}', [SupirController::class, 'destroy'])->name('supirs.destroy');

    // CRUD Harga Jual untuk Agen
    Route::get('/hargajual', [HargaJualController::class, 'index'])->name('hargajual.index');
    Route::get('/hargajual/create', [HargaJualController::class, 'create'])->name('hargajual.create');
    Route::post('/hargajual', [HargaJualController::class, 'store'])->name('hargajual.store');
    Route::get('/hargajual/{id}/edit', [HargaJualController::class, 'edit'])->name('hargajual.edit');
    Route::put('/hargajual/{id}', [HargaJualController::class, 'update'])->name('hargajual.update');

    // CRUD Pemesanan untuk Agen
    Route::get('/pemesanan', [PemesananAgenController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/{id}', [PemesananAgenController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan/{id}/assign', [PemesananAgenController::class, 'assignSupir'])->name('pemesanan.assign');

    // CRUD Transaksi untuk Agen
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/get-pemesanan/{id}', [TransaksiController::class, 'getPemesanan'])->name('transaksi.get-pemesanan');
    Route::get('/transaksi/{id}/nota', [TransaksiController::class, 'nota'])->name('transaksi.nota');
    Route::get('/transaksi/{id}/nota', [TransaksiController::class, 'printNota'])->name('transaksi.nota');

    //laporan
    Route::get('/laporan-pencatatan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan-pencatatan/export', [LaporanController::class, 'export'])->name('agen.laporan.export');

    // Halaman Data Petani (lihat data petani + lahan)
    Route::get('/data-petani', [DataPetaniController::class, 'index'])->name('data-petani.index');

    //tracking supir
    Route::get('/tracking-supir', [TrackingController::class, 'index'])->name('tracking.index');

});

// ==================
// PETANI ROUTES
// ==================
Route::middleware(['auth:petani', 'otp.verified'])->prefix('petani')->name('petani.')->group(function () {
    Route::get('/dashboard', [PetaniController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PetaniController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [PetaniController::class, 'updateProfile'])->name('profile.update');
    Route::get('/ubah-password', [PetaniController::class, 'showPasswordForm'])->name('password.form');
    Route::put('/ubah-password', [PetaniController::class, 'updatePassword'])->name('password.update');

    // CRUD Lahan untuk Petani
    Route::get('/lahans', [LahanController::class, 'index'])->name('lahan.index');
    Route::get('/lahans/create', [LahanController::class, 'create'])->name('lahan.create');
    Route::post('/lahans', [LahanController::class, 'store'])->name('lahan.store');
    Route::get('/lahans/{id}/edit', [LahanController::class, 'edit'])->name('lahan.edit');
    Route::put('/lahans/{id}', [LahanController::class, 'update'])->name('lahan.update');
    Route::delete('/petani/lahan/{id}', [LahanController::class, 'destroy'])->name('lahan.destroy');

    // CRUD Pemesanan oleh Petani
    Route::get('/pemesanan', [PemesananPetaniController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/create', [PemesananPetaniController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan', [PemesananPetaniController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{id}', [PemesananPetaniController::class, 'show'])->name('pemesanan.show');
    Route::put('/pemesanan/{id}/batal', [PemesananPetaniController::class, 'batal'])->name('pemesanan.batal');
    Route::delete('/pemesanan/{id}', [PemesananPetaniController::class, 'destroy'])->name('pemesanan.destroy');
    Route::get('/petani/pemesanan/{id}/edit', [PemesananPetaniController::class, 'edit'])->name('pemesanan.edit');
    Route::put('/petani/pemesanan/{id}', [PemesananPetaniController::class, 'update'])->name('pemesanan.update');

    // Riwayat transaksi
    Route::get('/transaksi', [TransaksiPetaniController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiPetaniController::class, 'show'])->name('transaksi.show');

    // Harga jual untuk petani
    Route::get('/harga-jual', [HargaJualPetaniController::class, 'index'])->name('hargajual.index');

    //Data Supir
    Route::get('/supir', [SupirPetaniController::class, 'index'])->name('supir.index');
});

// ==================
// SUPIR ROUTES
// ==================
Route::middleware(['auth:supir', 'otp.verified'])->prefix('supir')->name('supir.')->group(function () {
    Route::get('/dashboard', [SupirSupirController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [SupirSupirController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [SupirSupirController::class, 'updateProfile'])->name('profile.update');

    Route::get('/pemesanan', [PemesananSupirController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/{id}', [PemesananSupirController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan/{id}/status', [PemesananSupirController::class, 'updateStatus'])->name('pemesanan.updateStatus');


    //Track Record Supir
    Route::get('/trackrecord', [TrackRecordController::class, 'index'])->name('trackrecord.index');

    Route::post('/update-lokasi', [PemesananSupirController::class, 'updateLokasi'])->name('update-lokasi');
});

// Ini BENAR — hanya butuh 'auth', TIDAK pakai 'otp.verified'
Route::middleware(['web', 'anyauth'])->prefix('otp')->name('otp.')->group(function () {
    Route::get('/pilih', [OtpController::class, 'showMethodForm'])->name('choose');
    Route::post('/kirim', [OtpController::class, 'send'])->name('send');
    Route::get('/verifikasi', [OtpController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('/verifikasi', [OtpController::class, 'verify'])->name('verify');
});