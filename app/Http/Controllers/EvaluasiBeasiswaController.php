<?php

namespace App\Http\Controllers;

use App\Models\Terima;
use Illuminate\Http\Request;

class EvaluasiBeasiswaController extends Controller
{
    public function index()
    {
        $semuaPenerima = Terima::fromQuery(Terima::queryPenerimaBeasiswa(), ['SMT' => Terima::TEMP_SMT])
            ->load('mahasiswa', 'jenis_beasiswa1', 'jenis_beasiswa2');

        return view('evaluasi-beasiswa', compact('semuaPenerima'));
    }

    public function detail($nim)
    {
        $penerima = Terima::fromQuery(Terima::queryPenerimaBeasiswa(), ['SMT' => Terima::TEMP_SMT]);

        $penerima = $penerima->where('nim', $nim)->first();

        $jenis_beasiswa = Terima::getNamaRelasiJnsBea($penerima->pilihan_ke);


        return view('detil-evaluasi-beasiswa', compact('penerima', 'jenis_beasiswa'));
    }
}
