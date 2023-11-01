<?php

use App\Http\Controllers\EvaluasiBeasiswaController;
use App\Http\Controllers\HistoriController;
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

Route::middleware(['set.semester'])->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/evaluasi-beasiswa', [EvaluasiBeasiswaController::class, 'index'])->name('index-evaluasi-beasiswa');

    Route::get('/detil-evaluasi-beasiswa/{nim}', [EvaluasiBeasiswaController::class, 'detail'])->name('detil-evaluasi-beasiswa');

    Route::get('/mol-evbsw', function () {
        return redirect()->route('index-evaluasi-beasiswa')
            ->with('success', 'Evaluasi berhasil disimpan');
    })->name('mol-evbsw');


    Route::get('/histori', [HistoriController::class, 'index'])->name('index-histori');
});
