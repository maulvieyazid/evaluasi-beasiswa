<?php

namespace App\Http\Controllers;

use App\Models\HisMf;
use App\Models\Terima;
use App\Models\Tsnilmaba;
use Illuminate\Http\Request;

class EvaluasiBeasiswaController extends Controller
{
    public function index()
    {
        $semuaPenerima = Terima::fromQuery(Terima::queryPenerimaBeasiswa(), ['SMT' => session('semester')])
            ->load('mahasiswa', 'jenis_beasiswa1', 'jenis_beasiswa2');

        return view('evaluasi-beasiswa', compact('semuaPenerima'));
    }

    public function detail($nim)
    {
        $penerima = Terima::fromQuery(Terima::queryPenerimaBeasiswa(), ['SMT' => session('semester')]);

        $penerima = $penerima->where('nim', $nim)->first();

        $jenis_beasiswa = Terima::getNamaRelasiJnsBea($penerima->pilihan_ke);

        $hismf = HisMf::where('mhs_nim', $nim)
            ->where('semester', session('semester'))
            ->first();

        $sskm = Tsnilmaba::where('nim', $nim)->sum('nilai');

        return view('detil-evaluasi-beasiswa', compact('penerima', 'jenis_beasiswa', 'hismf', 'sskm'));
    }
}
