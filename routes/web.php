<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SSEController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardMenuController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route User Dashboard
Route::get('/', [DashboardUserController::class, 'index'])->name('dashboard');
Route::get('/keanggotaan', [DashboardUserController::class, 'indexKeanggotaan'])->name('keanggotaan');
Route::get('/simpanPinjam', [DashboardUserController::class, 'indexSimpanPinjam'])->name('simpanPinjam');
Route::get('/keunggulan', [DashboardUserController::class, 'indexKeunggulan'])->name('keunggulan');
Route::get('/eventMedia', [DashboardUserController::class, 'indexEventMedia'])->name('eventMedia');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login', [LoginController::class, 'loginAction'])->name('login.action');

    Route::get('register', [RegisterController::class, 'register'])->name('register');
    Route::post('register', [RegisterController::class, 'registerAction'])->name('register.action');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::group(['middleware' => ['web', 'auth', 'verified']], function () {

    Route::group(['prefix' => 'sse'], function() {
        Route::get('TotalAllChart', [SSEController::class, 'TotalAllChart'])->name('TotalAllChart');
        // Route::get('getTotalPinjaman', [SSEController::class, 'getTotalPinjaman'])->name('getTotalPinjaman');
        Route::get('dendaPinjamanSSE', [SSEController::class, 'dendaPinjamanSSE'])->name('dendaPinjamanSSE');
        Route::get('denda_pinjaman', [SSEController::class, 'denda_pinjaman'])->name('denda_pinjaman');
        Route::get('getlaporan', [SSEController::class, 'getlaporan'])->name('getlaporan');
        Route::get('getlaporanSimpan', [SSEController::class, 'getlaporanSimpan'])->name('getlaporanSimpan');
        Route::get('getlaporanTarik', [SSEController::class, 'getlaporanTarik'])->name('getlaporanTarik');
        Route::get('getlaporanPotong', [SSEController::class, 'getlaporanPotong'])->name('getlaporanPotong');
        Route::get('getSaldoPerUser', [SSEController::class, 'getSaldoPerUser'])->name('getSaldoPerUser');
        Route::get('getlaporanPinjam', [SSEController::class, 'getlaporanPinjam'])->name('getlaporanPinjam');


        Route::get('getTotalNasabah', [SSEController::class, 'getTotalNasabah'])->name('getTotalNasabah');
        Route::get('getTotalSimpanan', [SSEController::class, 'getTotalSimpanan'])->name('getTotalSimpanan');
        Route::get('getTotalPinjaman', [SSEController::class, 'getTotalPinjaman'])->name('getTotalPinjaman');
        Route::get('getRekapKeuangan', [DashboardMenuController::class, 'getRekapKeuangan'])->name('getRekapKeuangan');
        Route::get('getTotalPinjamanHome', [DashboardMenuController::class, 'getTotalPinjamanHome'])->name('getTotalPinjamanHome');
    });
    // Route::get('/Pinjam', [PinjamanController::class, 'index'])->name('Pinjam.index');
    // Route::get('/Crate-Pinjam', [PinjamanController::class, 'create'])->name('Pinjam.create');


    Route::group(['prefix' => 'home'], function() {
        Route::get('/', [DashboardMenuController::class, 'index'])->name('home');
    });

    Route::group(['prefix' => 'anggota'], function() {
        Route::get('/', [AnggotaController::class, 'index'])->name('anggota.index');
        Route::get('create', [AnggotaController::class, 'create'])->name('anggota.create');
        Route::post('store', [AnggotaController::class, 'store'])->name('anggota.store');
        // Route::get('edit/{id}', [AnggotaController::class, 'edit'])->name('anggota.edit');
        Route::get('show/{id}', [AnggotaController::class, 'show'])->name('anggota.show');
        Route::patch('update/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
        Route::get('edit_password/{id}', [AnggotaController::class, 'edit_password'])->name('anggota.edit_password');
        Route::patch('updatePassword/{id}', [AnggotaController::class, 'updatePassword'])->name('anggota.updatePassword');
    });


    Route::group(['prefix' => 'pinjaman'], function() {
        Route::get('/', [PinjamanController::class, 'index'])->name('pinjaman.index');
        Route::get('create', [PinjamanController::class, 'create'])->name('pinjaman.create');
        Route::post('store', [PinjamanController::class, 'store'])->name('pinjaman.store');
        Route::get('show/{id}', [PinjamanController::class, 'show'])->name('pinjaman.show');
        Route::get('bayar/{id}', [PinjamanController::class, 'bayar'])->name('pinjaman.bayar');
        Route::post('approve/{id}', [PinjamanController::class, 'approve'])->name('pinjaman.approve');
        Route::post('reject/{id}', [PinjamanController::class, 'reject'])->name('pinjaman.reject');
        Route::patch('update/{id}', [PinjamanController::class, 'update'])->name('pinjaman.update');
        Route::patch('bayar/update/{id}', [PinjamanController::class, 'proses_bayar'])->name('pinjaman.proses_bayar');
        Route::post('destroy', [PinjamanController::class, 'destroy'])->name('pinjaman.destroy');
    });

    Route::group(['prefix' => 'simpanan'], function() {
        Route::get('/', [SimpananController::class, 'index'])->name('simpanan.index');
        Route::get('create', [SimpananController::class, 'create'])->name('simpanan.create');
        Route::post('store', [SimpananController::class, 'store'])->name('simpanan.store');
        Route::get('edit/{id}', [SimpananController::class, 'edit'])->name('simpanan.edit');
        Route::get('show/{id}', [SimpananController::class, 'show'])->name('simpanan.show');
        Route::patch('update/{id}', [SimpananController::class, 'update'])->name('simpanan.update');
    });


    Route::group(['prefix' => 'laporan'], function() {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan');
        Route::get('/simpanan', [LaporanController::class, 'laporan_simpanan'])->name('laporan.simpanan');
        Route::get('/pinjaman', [LaporanController::class, 'laporan_pinjaman'])->name('laporan.pinjaman');
        Route::get('/get-pinjaman', [LaporanController::class, 'getDataPinjaman'])->name('laporan.getPinjaman');
        Route::get('/get-data', [LaporanController::class, 'getDataAjax'])->name('laporan.getDataAjax');

    });

    Route::group(['prefix' => 'profile'], function() {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('profile');
        Route::patch('update/{id}', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('destroy', [ProfileController::class, 'destroy'])->name('saldo.destroy');
    });
});
