<?php

namespace App\Http\Controllers;

use App\Models\Terima;
use Illuminate\Http\Request;

class EvaluasiBeasiswaController extends Controller
{
    public function index()
    {
        $penerima = Terima::fromQuery(Terima::queryPenerimaBeasiswa(), ['SMT' => Terima::TEMP_SMT])
            ->load('mahasiswa', 'jenis_beasiswa1', 'jenis_beasiswa2');

        return view('evaluasi-beasiswa', compact('penerima'));
    }

    public function detail()
    {
        return view('detil-evaluasi-beasiswa');
    }
}
