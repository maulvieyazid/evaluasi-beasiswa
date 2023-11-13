<?php

namespace App\Http\Controllers;

use App\Models\HisMf;
use App\Models\JenisBeasiswaPmb;
use App\Models\KesimpulanBeasiswa;
use App\Models\Mahasiswa;
use App\Models\SyaratPesertaBeasiswa;
use App\Models\Terima;
use App\Models\Tsnilmaba;
use Illuminate\Http\Request;

class HistoriController extends Controller
{
    public function index()
    {
        $semuaPenerima = Terima::fromQuery(Terima::queryPenerimaBeasiswa(), ['SMT' => session('semester')])
            ->load('mahasiswa', 'jenis_beasiswa1', 'jenis_beasiswa2', 'syarat_peserta.syarat', 'kesimpulan_beasiswa');

        // Hapus / Buang penerima beasiswa yang BELUM dievaluasi oleh bagian yang LOGIN
        // ATAU
        // yang sudah masuk ke Kesimpulan Beasiswa
        $semuaPenerima = $semuaPenerima->reject(function ($penerima, $key) {
            // return FALSE : artinya penerima beasiswa TIDAK DIBUANG
            // return TRUE : artinya penerima beasiswa DIBUANG

            // Kalau jumlah syarat_peserta nya sama dengan 0, berarti belum ada evaluasi
            if ($penerima->syarat_peserta->count() == 0) return true;

            // Kalau di dalam syarat_peserta tidak ada syarat yang bagian validasi nya adalah bagian yang LOGIN,
            // berarti sudah ada evaluasi, tapi yang mengevaluasi bukan bagian yang LOGIN
            if ($penerima->syarat_peserta->where('syarat.bagian_validasi', auth()->user()->bagian)->count() == 0) return true;

            // Kalau data penerima nya sudah masuk ke kesimpulan_beasiswa, berarti sudah dievaluasi oleh Bagian Keuangan
            if ($penerima->kesimpulan_beasiswa->count() > 0) return true;

            return false;
        });


        $semuaKesimpulan = KesimpulanBeasiswa::query()
            ->orderBy('smt', 'desc')
            ->orderBy('mhs_nim', 'desc')
            ->with(['mahasiswa', 'jenis_beasiswa'])
            ->get();


        return view('histori', compact('semuaPenerima', 'semuaKesimpulan'));
    }

    public function detail($nim, $jns_beasiswa, $smt)
    {
        $mhs = Mahasiswa::where('nim', $nim)->first();

        // Kalau mahasiswa nya tidak ada, maka return ke index histori
        if (!$mhs) return redirect()->route('index-histori');

        $jenis_bea = JenisBeasiswaPmb::where('kd_jenis', $jns_beasiswa)->first();

        $kesimpulan = KesimpulanBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $jns_beasiswa)
            ->where('smt', $smt)
            ->first();

        $hismf = HisMf::where('mhs_nim', $nim)
            ->where('semester', $smt)
            ->first();

        $sskm = Tsnilmaba::where('nim', $nim)->sum('nilai');

        $semuaSyarat = SyaratPesertaBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $jns_beasiswa)
            ->where('smt', $smt)
            ->with('syarat')
            ->get();

        return view('detil-histori', compact(
            'mhs',
            'jenis_bea',
            'kesimpulan',
            'hismf',
            'sskm',
            'semuaSyarat',
            'smt'
        ));
    }
}
