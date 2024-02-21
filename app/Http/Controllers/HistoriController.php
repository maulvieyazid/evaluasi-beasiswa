<?php

namespace App\Http\Controllers;

use App\Models\HisMf;
use App\Models\JenisBeasiswaPmb;
use App\Models\KesimpulanBeasiswa;
use App\Models\Mahasiswa;
use App\Models\SimpulBagian;
use App\Models\SyaratBeasiswa;
use App\Models\SyaratPesertaBeasiswa;
use App\Models\Terima;
use App\Models\Tsnilmaba;
use Illuminate\Http\Request;

class HistoriController extends Controller
{
    public function index()
    {
        // NOTE : Kenapa data yang ditampilkan ada 2 yaitu model Terima dan model KesimpulanBeasiswa
        // Karena halaman histori ini bisa diakses oleh siapapun dan dari bagian manapun,
        // sehingga ada kemungkinan ada data yang belum masuk ke KesimpulanBeasiswa tetapi sebenarnya sudah dievaluasi oleh bagian tersebut.
        //
        // Contoh :
        // Saya login sebagai Kabag AAK, lalu saya melakukan evaluasi pada seorang mhs,
        // maka mhs tsb seharusnya sudah tidak muncul di halaman Evaluasi Beasiswa melainkan masuk ke halaman Histori.
        // dan di halaman Histori, mhs tersebut statusnya "Menunggu Evaluasi Keuangan".
        // Dalam kasus diatas, data mhs tsb sudah dievaluasi, tetapi belum masuk ke KesimpulanBeasiswa,
        // karena KesimpulanBeasiswa baru diinput saat Kabag Keuangan melakukan evaluasi.



        $semuaPenerima = Terima::fromQuery(Terima::queryPenerimaBeasiswa(), ['SMT' => session('semester')])
            ->load('mahasiswa', 'jenis_beasiswa_pmb', 'syarat_peserta.syarat', 'kesimpulan_beasiswa');

        // Hapus / Buang penerima beasiswa yang BELUM dievaluasi oleh bagian yang LOGIN
        // ATAU
        // yang sudah masuk ke Kesimpulan Beasiswa
        $semuaPenerima = $semuaPenerima->reject(function ($penerima, $key) {
            // return FALSE : artinya penerima beasiswa TIDAK DIBUANG
            // return TRUE : artinya penerima beasiswa DIBUANG

            // Kalau jumlah 'syarat_peserta' nya sama dengan 0, berarti belum ada evaluasi
            if ($penerima->syarat_peserta->count() == 0) return true;

            // Kalau di dalam 'syarat_peserta' tidak ada syarat yang bagian validasi nya adalah bagian yang LOGIN,
            // berarti sudah ada evaluasi, tapi yang mengevaluasi bukan bagian yang LOGIN
            if ($penerima->syarat_peserta->where('syarat.bagian_validasi', auth()->user()->bagian)->count() == 0) return true;

            // Kalau data penerima nya sudah masuk ke 'kesimpulan_beasiswa', berarti sudah dievaluasi oleh Bagian Keuangan
            if ($penerima->kesimpulan_beasiswa->count() > 0) return true;

            return false;
        });

        // Ambil data Kesimpulan Beasiswa (penerima beasiswa yang sudah dievaluasi oleh Bagian Keuangan)
        $semuaKesimpulan = KesimpulanBeasiswa::query()
            ->orderBy('smt', 'desc')
            ->orderBy('mhs_nim', 'desc')
            ->with(['mahasiswa', 'jenis_beasiswa_pmb'])
            ->get();


        return view('histori', compact('semuaPenerima', 'semuaKesimpulan'));
    }

    public function detail($nim, $kd_jns_bea_pmb, $smt)
    {
        $mhs = Mahasiswa::where('nim', $nim)->first();

        // Kalau mahasiswa nya tidak ada, maka return ke index histori
        if (!$mhs) return redirect()->route('index-histori');

        $jenis_bea_pmb = JenisBeasiswaPmb::where('kd_jenis', $kd_jns_bea_pmb)->first();

        $kesimpulan = KesimpulanBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $kd_jns_bea_pmb)
            ->where('smt', $smt)
            ->first();

        $hismf = HisMf::where('mhs_nim', $nim)
            ->where('semester', $smt)
            ->first();

        $sskm = Tsnilmaba::where('nim', $nim)->sum('nilai');

        // Data master syarat beasiswa
        $semuaSyarat = SyaratBeasiswa::query()
            ->where('jenis_beasiswa', $kd_jns_bea_pmb)
            ->get();

        // Nilai evaluasi dari master syarat beasiswa
        $semuaSyaratPeserta = SyaratPesertaBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $kd_jns_bea_pmb)
            ->where('smt', $smt)
            ->get();

        $semuaSimpulBagian = SimpulBagian::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $kd_jns_bea_pmb)
            ->where('smt', $smt)
            ->get();

        return view('detil-histori', compact(
            'mhs',
            'jenis_bea_pmb',
            'kesimpulan',
            'hismf',
            'sskm',
            'semuaSyarat',
            'semuaSyaratPeserta',
            'semuaSimpulBagian',
            'smt'
        ));
    }
}
