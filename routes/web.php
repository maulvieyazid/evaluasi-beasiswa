<?php

use App\Http\Controllers\EvaluasiBeasiswaController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SyaratBeasiswaController;
use App\Http\Controllers\SyaratPesertaBeasiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['set.semester', 'auth'])->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/evaluasi-beasiswa', [EvaluasiBeasiswaController::class, 'index'])->name('index-evaluasi-beasiswa');

    Route::get('/detil-evaluasi-beasiswa/{nim}', [EvaluasiBeasiswaController::class, 'detail'])->name('detil-evaluasi-beasiswa');

    Route::post('/simpan-detil-evaluasi', [EvaluasiBeasiswaController::class, 'simpanDetail'])->name('simpan-detil-evaluasi');

    Route::get('/mol-evbsw', function () {
        return redirect()->route('index-evaluasi-beasiswa')
            ->with('success', 'Evaluasi berhasil disimpan');
    })->name('mol-evbsw');


    Route::get('/histori', [HistoriController::class, 'index'])->name('index-histori');
});

Route::get('/syarat-util-ins', [SyaratBeasiswaController::class, 'utilInsert']);
Route::get('/syarat-util-upd', [SyaratBeasiswaController::class, 'utilUpdate']);
Route::get('/syarat-util-del/{jenis_beasiswa}/{kd_syarat}', [SyaratBeasiswaController::class, 'utilDelete']);



Route::get('/syarat-peserta-util-del/{mhs_nim}/{jns_beasiswa}/{smt}/{kd_syarat}', [SyaratPesertaBeasiswaController::class, 'utilDelete']);
