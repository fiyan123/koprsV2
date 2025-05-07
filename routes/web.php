<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardMenuController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SimpananController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    Route::get('/Pinjam', [PinjamanController::class, 'index'])->name('Pinjam.index');
    Route::get('/Crate-Pinjam', [PinjamanController::class, 'create'])->name('Pinjam.create');

    Route::group(['prefix' => 'home'], function() {
        Route::get('/', [DashboardMenuController::class, 'index'])->name('home');
        Route::get('create', [DashboardMenuController::class, 'create'])->name('home.create');
        Route::post('store', [DashboardMenuController::class, 'store'])->name('home.store');
        Route::get('edit/{id}', [DashboardMenuController::class, 'edit'])->name('home.edit');
        Route::get('show/{id}', [DashboardMenuController::class, 'show'])->name('home.show');
        Route::patch('update/{id}', [DashboardMenuController::class, 'update'])->name('home.update');
        Route::post('destroy', [DashboardMenuController::class, 'destroy'])->name('home.destroy');
    });

    Route::group(['prefix' => 'simpanan'], function() {
        Route::get('/', [SimpananController::class, 'index'])->name('simpanan');
        Route::get('create', [SimpananController::class, 'create'])->name('simpanan.create');
        Route::post('store', [SimpananController::class, 'store'])->name('simpanan.store');
        Route::get('edit/{id}', [SimpananController::class, 'edit'])->name('simpanan.edit');
        Route::get('show/{id}', [SimpananController::class, 'show'])->name('simpanan.show');
        Route::patch('update/{id}', [SimpananController::class, 'update'])->name('simpanan.update');
        Route::post('destroy', [SimpananController::class, 'destroy'])->name('simpanan.destroy');
    });
});
