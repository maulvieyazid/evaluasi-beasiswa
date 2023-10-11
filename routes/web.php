<?php

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/evaluasi-beasiswa', function () {
    return view('evaluasi-beasiswa');
})->name('index-evaluasi-beasiswa');

Route::get('/detil-evaluasi-beasiswa', function () {
    return view('detil-evaluasi-beasiswa');
})->name('detil-evaluasi-beasiswa');
