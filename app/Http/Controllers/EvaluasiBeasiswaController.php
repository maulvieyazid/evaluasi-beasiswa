<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\HisMf;
use App\Models\KesimpulanBeasiswa;
use App\Models\SyaratBeasiswa;
use App\Models\SyaratPesertaBeasiswa;
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

        // Kalo penerima nya gk ada, langsung redirect kembali aja
        if (!$penerima) return redirect()->back();

        $jenis_beasiswa = Terima::getNamaRelasiJnsBea($penerima->pilihan_ke);

        $hismf = HisMf::where('mhs_nim', $nim)
            ->where('semester', session('semester'))
            ->first();

        $sskm = Tsnilmaba::where('nim', $nim)->sum('nilai');

        $semuaSyarat = SyaratBeasiswa::query()
            ->where('jenis_beasiswa', $penerima->{$jenis_beasiswa}->kd_jenis)
            ->get();

        return view('detil-evaluasi-beasiswa', compact(
            'penerima',
            'jenis_beasiswa',
            'hismf',
            'sskm',
            'semuaSyarat',
        ));
    }

    function simpanDetail(Request $req)
    {
        // Ambil syarat yang jenis beasiswa nya sesuai data request
        // DAN
        // bagian_validasi nya sesuai dengan bagian yang LOGIN
        $semuaSyarat = SyaratBeasiswa::query()
            ->where('jenis_beasiswa', $req->jns_beasiswa)
            ->where('bagian_validasi', auth()->user()->bagian)
            ->get();

        // dd($req->all(), auth()->user(), $semuaSyarat);

        // Lakukan looping
        foreach ($semuaSyarat as $syarat) {

            // Cek di masing2 syarat, apakah kd_syarat nya ada di data request syarat_beasiswa
            // Kalo ada maka statusnya lolos, kalo gk ada maka statusnya tidak lolos
            $status = in_array($syarat->kd_syarat, $req->syarat_beasiswa)
                ? SyaratPesertaBeasiswa::LOLOS
                : SyaratPesertaBeasiswa::TIDAK_LOLOS;

            // Insert ke SyaratPesertaBeasiswa
            SyaratPesertaBeasiswa::create([
                'mhs_nim'      => $req->nim,
                'jns_beasiswa' => $req->jns_beasiswa,
                'smt'          => $req->smt,
                'kd_syarat'    => $syarat->kd_syarat,
                'status'       => $status,
                'keterangan'   => null,
            ]);

            // FUTURE : Simpan ke Log Syarat
        }

        // Insert ke Kesimpulan Beasiswa, hanya jika yang login adalah Bagian Keuangan
        if (auth()->user()->bagian == Departemen::KEUANGAN) {
            KesimpulanBeasiswa::create([
                'mhs_nim'      => $req->nim,
                'jns_beasiswa' => $req->jns_beasiswa,
                'smt'          => $req->smt,
                'status'       => $req->status_kesimpulan,
                'keterangan'   => null,
            ]);

            // FUTURE : Simpan ke Log Simpulan
        }

        return redirect()->route('index-evaluasi-beasiswa')
            ->with('success', 'Evaluasi Beasiswa berhasil disimpan');
    }
}
