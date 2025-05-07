<?php

use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\PinjamanController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('layouts.admin');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/Pinjam', [PinjamanController::class, 'index'])->name('Pinjam.index');
Route::get('/Add-Pinjam', [PinjamanController::class, 'create'])->name('Pinjam.create');
// Route User Dashboard
Route::get('/dashboard', [DashboardUserController::class, 'index'])->name('dashboard');
Route::get('/keanggotaan', [DashboardUserController::class, 'indexKeanggotaan'])->name('keanggotaan');
Route::get('/simpanPinjam', [DashboardUserController::class, 'indexSimpanPinjam'])->name('simpanPinjam');
Route::get('/keunggulan', [DashboardUserController::class, 'indexKeunggulan'])->name('keunggulan');
Route::get('/eventMedia', [DashboardUserController::class, 'indexEventMedia'])->name('eventMedia');
