<?php

use App\Http\Controllers\EvaluasiBeasiswaController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SyaratBeasiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KesimpulanBeasiswaController;
use App\Http\Controllers\SyaratPesertaBeasiswaController;

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

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/evaluasi-beasiswa', [EvaluasiBeasiswaController::class, 'index'])->name('index-evaluasi-beasiswa');

    Route::get('/detil-evaluasi-beasiswa/{nim}', [EvaluasiBeasiswaController::class, 'detail'])->name('detil-evaluasi-beasiswa');

    Route::post('/simpan-detil-evaluasi', [EvaluasiBeasiswaController::class, 'simpanDetail'])->name('simpan-detil-evaluasi');


    Route::get('/histori', [HistoriController::class, 'index'])->name('index-histori');
    Route::get('/detil-histori/{nim}/{kd_jns_bea_pmb}/{smt}', [HistoriController::class, 'detail'])->name('detil-histori');



    Route::get('/maintenance-syarat-beasiswa', [SyaratBeasiswaController::class, 'index'])->name('index.master-syarat-beasiswa');
    Route::get('/detil-maintenance-syarat-beasiswa/{kd_jenis}', [SyaratBeasiswaController::class, 'detail'])->name('detil.master-syarat-beasiswa');


    /*
     | -------------------------------------------------
     | Route Khusus untuk Me-rollback Penerima Beasiswa
     | -------------------------------------------------
     | Ini digunakan untuk menghapus data Syarat Peserta Beasiswa dan Kesimpulan Beasiswa
     */
    Route::get('/special-util/rollback/{nim}/{kd_jns_bea_pmb}/{smt}', [EvaluasiBeasiswaController::class, 'showRollbackForm'])->name('rollback-beasiswa');
    Route::post('/special-util/rollback/{nim}/{kd_jns_bea_pmb}/{smt}', [EvaluasiBeasiswaController::class, 'rollback']);
});


Route::post('/maintenance-syarat-beasiswa/store/json', [SyaratBeasiswaController::class, 'storeJson'])->name('store-json.master-syarat-beasiswa');
Route::put('/maintenance-syarat-beasiswa/update/json', [SyaratBeasiswaController::class, 'updateJson'])->name('update-json.master-syarat-beasiswa');
Route::delete('/maintenance-syarat-beasiswa/destroy/json', [SyaratBeasiswaController::class, 'destroyJson'])->name('destroy-json.master-syarat-beasiswa');


// Route untuk mengambil data chart
// Per Semester
Route::get('/chart/jml-pnrm-bea-per-smt', [HomeController::class, 'getJmlPenerimaPerSmt'])->name('chart.get.jml-penerima-per-smt');
Route::get('/detail-chart/jml-pnrm-bea-per-smt/{smt}', [HomeController::class, 'getDetailJmlPenerimaPerSmt'])->name('chart.get.detail-jml-penerima-per-smt');

// Per Jenis Beasiswa
Route::get('/chart/jml-pnrm-bea-per-jenis-beasiswa/{smt}', [HomeController::class, 'getJmlPenerimaPerJenisBeasiswa'])->name('chart.get.jml-penerima-per-jenis-beasiswa');
Route::get('/detail-chart/jml-pnrm-bea-per-jenis-beasiswa/{smt}/{kd_jenis}', [HomeController::class, 'getDetailJmlPenerimaPerJenisBeasiswa'])->name('chart.get.detail-jml-penerima-per-jenis-beasiswa');

// Prosentase Aktif Gugur
Route::get('/chart/prsnts-pnrm-bea-aktf-ggr/{smt}', [HomeController::class, 'getPrsntsPenerimaAktfGgr'])->name('chart.get.prsnts-penerima-aktf-ggr');
Route::get('/detail-chart/prsnts-pnrm-bea-aktf-ggr/{smt}/{status}', [HomeController::class, 'getDetailPrsntsPenerimaAktfGgr'])->name('chart.get.detail-prsnts-penerima-aktf-ggr');








# Route utilitas untuk menghapus Syarat Peserta Beasiswa
// Route::get('/syarat-peserta-util-del/{mhs_nim}/{kd_jns_bea_pmb}/{smt}/{kd_syarat}', [SyaratPesertaBeasiswaController::class, 'utilDelete']);

# Route utilitas untuk menghapus Kesimpulan Beasiswa
// Route::get('/kesimpulan-util-del/{mhs_nim}/{kd_jns_bea_pmb}/{smt}', [KesimpulanBeasiswaController::class, 'utilDelete']);
