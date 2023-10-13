<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvaluasiBeasiswaController extends Controller
{
    public function index() {
        return view('evaluasi-beasiswa');
    }

    public function detail() {
        return view('detil-evaluasi-beasiswa');
    }
}
