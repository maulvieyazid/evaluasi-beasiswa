<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\HisMf;
use App\Models\KesimpulanBeasiswa;
use App\Models\LogKesimpulan;
use App\Models\LogSyarat;
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
            ->load('mahasiswa', 'jenis_beasiswa1', 'jenis_beasiswa2', 'syarat_peserta.syarat');

        // Hapus / Buang penerima beasiswa yang SUDAH dievaluasi oleh bagian yang LOGIN
        $semuaPenerima = $semuaPenerima->reject(function ($penerima, $key) {
            // return FALSE : artinya penerima beasiswa TIDAK DIBUANG
            // return TRUE : artinya penerima beasiswa DIBUANG

            // Kalau jumlah syarat_peserta nya sama dengan 0, berarti belum ada evaluasi
            if ($penerima->syarat_peserta->count() == 0) return false;

            // Kalau di dalam syarat_peserta tidak ada syarat yang bagian validasi nya adalah bagian yang LOGIN,
            // berarti sudah ada evaluasi, tapi yang mengevaluasi bukan bagian yang LOGIN
            if ($penerima->syarat_peserta->where('syarat.bagian_validasi', auth()->user()->bagian)->count() == 0) return false;

            return true;
        });

        return view('evaluasi-beasiswa', compact('semuaPenerima'));
    }

    public function detail($nim)
    {
        // Ambil semua penerima beasiswa
        $penerima = Terima::fromQuery(Terima::queryPenerimaBeasiswa(), ['SMT' => session('semester')]);

        // Ambil penerima yang nim nya sama dengan nim di url
        $penerima = $penerima->where('nim', $nim)->first();

        // Kalo penerima nya gk ada, langsung redirect kembali aja
        if (!$penerima) return redirect()->back();

        // Ambil nama relasi jenis beasiswa nya penerima
        $jenis_beasiswa = Terima::getNamaRelasiJnsBea($penerima->pilihan_ke);

        // Load relasi SyaratPesertaBeasiswa dan JenisBeasiswa nya penerima
        $penerima = $penerima->load(['syarat_peserta', $jenis_beasiswa]);

        // Data HisMf untuk mengambil Status Perkuliahan dan nilai IPS nya penerima
        $hismf = HisMf::where('mhs_nim', $nim)
            ->where('semester', session('semester'))
            ->first();

        // Ambil jumlah nilai sskm
        $sskm = Tsnilmaba::where('nim', $nim)->sum('nilai');

        // Data master syarat beasiswa
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

            // Simpan ke Log Syarat
            LogSyarat::create([
                'mhs_nim'      => $req->nim,
                'jns_beasiswa' => $req->jns_beasiswa,
                'smt'          => $req->smt,
                'kd_syarat'    => $syarat->kd_syarat,
                'nm_user'      => auth()->user()->nama,
                'sts_old'      => null,
                'sts_new'      => $status,
                'ket_old'      => null,
                'ket_new'      => null,
            ]);
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

            // Simpan ke Log Kesimpulan
            LogKesimpulan::create([
                'mhs_nim'      => $req->nim,
                'jns_beasiswa' => $req->jns_beasiswa,
                'smt'          => $req->smt,
                'nm_user'      => auth()->user()->nama,
                'sts_old'      => null,
                'sts_new'      => $req->status_kesimpulan,
                'ket_old'      => null,
                'ket_new'      => null,
            ]);
        }

        return redirect()->route('index-evaluasi-beasiswa')
            ->with('success', 'Evaluasi Beasiswa berhasil disimpan');
    }


    function showRollbackForm($nim, $jns_beasiswa, $smt)
    {
        $penerima = KesimpulanBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $jns_beasiswa)
            ->where('smt', $smt)
            ->with(['mahasiswa', 'jenis_beasiswa'])
            ->first();

        if (!$penerima) return "Penerima Beasiswa tidak ditemukan";

        return view('utilities.rollback-form', compact('penerima'));
    }

    function rollback($nim, $jns_beasiswa, $smt)
    {
        $semuaSyarat = SyaratPesertaBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $jns_beasiswa)
            ->where('smt', $smt)
            ->get();


        foreach ($semuaSyarat as $syarat) {
            $syarat->delete();
        }

        $kesimpulan = KesimpulanBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $jns_beasiswa)
            ->where('smt', $smt)
            ->first();

        $kesimpulan->delete();

        return "Data Penerima Beasiswa sudah di rollback";
    }
}
