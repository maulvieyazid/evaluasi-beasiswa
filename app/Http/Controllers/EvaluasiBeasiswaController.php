<?php

namespace App\Http\Controllers;

use App\Models\BeasiswaPenmaru;
use App\Models\HisMf;
use App\Models\JenisBeasiswaPmb;
use App\Models\KesimpulanBeasiswa;
use App\Models\LogKesimpulan;
use App\Models\LogSyarat;
use App\Models\SimpulBagian;
use App\Models\SyaratBeasiswa;
use App\Models\SyaratPesertaBeasiswa;
use App\Models\Terima;
use App\Models\Tsnilmaba;
use Illuminate\Http\Request;

class EvaluasiBeasiswaController extends Controller
{
    public function index()
    {
        // Ambil KesimpulanBeasiswa pada semester aktif
        // Ini digunakan untuk mengecek apakah evaluasi beasiswa dari mahasiswa sudah mencapai final
        $kesimpulanBea = KesimpulanBeasiswa::query()
            ->where('smt', session('semester'))
            ->get();

        $semuaPenerima = Terima::fromQuery(Terima::queryPenerimaBeasiswa(), ['SMT' => session('semester')])
            ->load('mahasiswa', 'jenis_beasiswa_pmb', 'syarat_peserta.syarat', 'his_mf');

        // Hapus / Buang penerima beasiswa yang SUDAH dievaluasi oleh bagian yang LOGIN
        $semuaPenerima = $semuaPenerima->reject(function ($penerima, $key) use ($kesimpulanBea) {
            // return FALSE : artinya penerima beasiswa TIDAK DIBUANG
            // return TRUE : artinya penerima beasiswa DIBUANG

            // Kalau mhs sudah menempuh lebih dari 8 semester, maka mhs tidak bisa mendapatkan beasiswa lagi
            if ($penerima->his_mf->count() > 8) return true;

            // Kalau atribut 'is_beasiswa_dicabut' bernilai 1,
            // berarti penerima beasiswa memiliki data di 'kesimpulan_beasiswa' yang status nya 'T' atau berarti tidak lolos
            if ($penerima->is_beasiswa_dicabut) return true;

            // Kalau ada data penerima beasiswa di "kesimpulan_beasiswa", berarti mahasiswa ini sudah dievaluasi hingga final
            // atau berarti sudah lolos
            $is_evaluasi_mencapai_final = $kesimpulanBea
                ->where('mhs_nim', $penerima->nim)
                ->where('jns_beasiswa', $penerima->jns_beasiswa)
                ->count();

            if ($is_evaluasi_mencapai_final) return true;

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

        // Load relasi SyaratPesertaBeasiswa, JenisBeasiswaPmb dan SimpulBagian nya penerima
        $penerima = $penerima->load(['syarat_peserta', 'jenis_beasiswa_pmb', 'simpul_bagian']);

        // Data HisMf untuk mengambil Status Perkuliahan dan nilai IPS nya penerima
        $hismf = HisMf::where('mhs_nim', $nim)
            ->where('semester', session('semester'))
            ->first();

        // Ambil jumlah nilai sskm
        $sskm = Tsnilmaba::where('nim', $nim)->sum('nilai');

        // Data master syarat beasiswa
        $semuaSyarat = SyaratBeasiswa::query()
            ->where('jenis_beasiswa', $penerima->jenis_beasiswa_pmb->kd_jenis)
            ->get();

        return view('detil-evaluasi-beasiswa', compact(
            'penerima',
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
            ->where('jenis_beasiswa', $req->kd_jns_bea_pmb)
            ->where('bagian_validasi', auth()->user()->bagian)
            ->get();

        // Ini sebagai penanda apakah perlu mengisi alasan atau tidak
        // baik mhs yang tidak lolos maupun yang diloloskan oleh Kabag Keuangan
        $isPerluMengisiAlasan = false;

        // Lakukan looping
        foreach ($semuaSyarat as $syarat) {

            // Cek di masing2 syarat, apakah kd_syarat nya ada di data request syarat_beasiswa_yg_dicentang
            // Kalo ada maka statusnya lolos, kalo gk ada maka statusnya tidak lolos
            $status = in_array($syarat->kd_syarat, $req->syarat_beasiswa_yg_dicentang)
                ? SyaratPesertaBeasiswa::LOLOS
                : SyaratPesertaBeasiswa::TIDAK_LOLOS;

            // Kalo ada status yang tidak lolos, maka perlu mengisi alasan kenapa tidak lolos
            if ($status == SyaratPesertaBeasiswa::TIDAK_LOLOS) $isPerluMengisiAlasan = true;

            // Insert ke SyaratPesertaBeasiswa
            SyaratPesertaBeasiswa::create([
                'mhs_nim'      => $req->nim,
                'jns_beasiswa' => $req->kd_jns_bea_pmb,
                'smt'          => $req->smt,
                'kd_syarat'    => $syarat->kd_syarat,
                'status'       => $status,
                'keterangan'   => null,
            ]);

            // Simpan ke Log Syarat
            LogSyarat::create([
                'mhs_nim'      => $req->nim,
                'jns_beasiswa' => $req->kd_jns_bea_pmb,
                'smt'          => $req->smt,
                'kd_syarat'    => $syarat->kd_syarat,
                'nm_user'      => auth()->user()->nama,
                'sts_old'      => null,
                'sts_new'      => $status,
                'ket_old'      => null,
                'ket_new'      => null,
            ]);
        }


        // Kalo yang login Kabag Keuangan DAN ada input alasan nya,
        if (auth()->user()->is_kabag_keuangan && $req->alasan_evaluasi) {
            // maka perlu mengisi alasan
            $isPerluMengisiAlasan = true;
        }


        // Kalo perlu mengisi alasan, maka insertkan alasan nya ke SimpulBagian
        if ($isPerluMengisiAlasan) {
            SimpulBagian::create([
                'bagian'       => auth()->user()->bagian,
                'mhs_nim'      => $req->nim,
                'jns_beasiswa' => $req->kd_jns_bea_pmb,
                'smt'          => $req->smt,
                'status'       => $req->status_kesimpulan,
                'keterangan'   => $req->alasan_evaluasi,
            ]);
        }

        // Insert ke Kesimpulan Beasiswa, hanya jika yang login adalah Kabag Keuangan
        if (auth()->user()->is_kabag_keuangan) {
            KesimpulanBeasiswa::create([
                'mhs_nim'      => $req->nim,
                'jns_beasiswa' => $req->kd_jns_bea_pmb,
                'smt'          => $req->smt,
                'status'       => $req->status_kesimpulan,
                'keterangan'   => null,
            ]);

            // Simpan ke Log Kesimpulan
            LogKesimpulan::create([
                'mhs_nim'      => $req->nim,
                'jns_beasiswa' => $req->kd_jns_bea_pmb,
                'smt'          => $req->smt,
                'nm_user'      => auth()->user()->nama,
                'sts_old'      => null,
                'sts_new'      => $req->status_kesimpulan,
                'ket_old'      => null,
                'ket_new'      => null,
            ]);

            // Ambil data Jenis Beasiswa PMB
            $jenis_beasiswa_pmb = JenisBeasiswaPmb::where('kd_jenis', $req->kd_jns_bea_pmb)->with('jns_bea_aak')->first();

            // Kalo data Jenis Beasiswa PMB nya ada, dan status_kesimpulan nya adalah LOLOS, maka
            // insert ke model BeasiswaPenmaru
            if ($jenis_beasiswa_pmb && $req->status_kesimpulan == KesimpulanBeasiswa::LOLOS) {
                // Ambil prosentase diskon spp
                $prosentase = $this->getProsentaseBeaPenmaru($jenis_beasiswa_pmb);

                BeasiswaPenmaru::create([
                    'mhs_nim'      => $req->nim,
                    'semester'     => $req->smt,
                    'jns_beasiswa' => $jenis_beasiswa_pmb->jns_bea_aak->kode, // <- Kode Jenis Beasiswa AAK
                    'prosentase'   => $prosentase,
                ]);
            }
        }

        return redirect()->route('index-evaluasi-beasiswa')
            ->with('success', 'Evaluasi Beasiswa berhasil disimpan');
    }

    public function getProsentaseBeaPenmaru($jenis_beasiswa_pmb)
    {
        // WARNING : Permintaan PENMARU, jika beasiswa kuliah 0 rupiah, maka prosentase nya di set ke 0
        if ($jenis_beasiswa_pmb->kd_jenis == JenisBeasiswaPmb::KULIAH_0_RUPIAH) return 0;

        return $jenis_beasiswa_pmb->disc_spp;
    }


    function showRollbackForm($nim, $kd_jns_bea_pmb, $smt)
    {
        $penerima = KesimpulanBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $kd_jns_bea_pmb)
            ->where('smt', $smt)
            ->with(['mahasiswa', 'jenis_beasiswa_pmb'])
            ->first();

        if (!$penerima) return "Penerima Beasiswa tidak ditemukan";

        return view('utilities.rollback-form', compact('penerima'));
    }

    function rollback($nim, $kd_jns_bea_pmb, $smt)
    {
        // Hapus Syarat Peserta Beasiswa
        $semuaSyarat = SyaratPesertaBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $kd_jns_bea_pmb)
            ->where('smt', $smt)
            ->get();


        foreach ($semuaSyarat as $syarat) {
            $syarat->delete();
        }


        // Hapus Simpul Bagian
        $semuaSimpulBagian = SimpulBagian::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $kd_jns_bea_pmb)
            ->where('smt', $smt)
            ->get();

        foreach ($semuaSimpulBagian as $simpulBagian) {
            $simpulBagian->delete();
        }


        // Hapus Kesimpulan Beasiswa
        $kesimpulan = KesimpulanBeasiswa::query()
            ->where('mhs_nim', $nim)
            ->where('jns_beasiswa', $kd_jns_bea_pmb)
            ->where('smt', $smt)
            ->first();

        if ($kesimpulan) {
            $kesimpulan->delete();
        }


        // Ambil data Jenis Beasiswa PMB, karena kode jenis yang dilemparkan ke parameter adalah kode Jenis Beasiswa PMB
        // dari Jenis Beasiswa PMB, kita bisa mengambil kode Jenis Beasiswa AAK
        $jenis_beasiswa_pmb = JenisBeasiswaPmb::where('kd_jenis', $kd_jns_bea_pmb)->with('jns_bea_aak')->first();

        // Ambil data BeasiswaPenmaru
        $beaPenmaru = BeasiswaPenmaru::query()
            ->where('mhs_nim', $nim)
            ->where('semester', $smt)
            ->where('jns_beasiswa', $jenis_beasiswa_pmb->jns_bea_aak->kode) // <- Kode Jenis Beasiswa AAK
            ->first();

        if ($beaPenmaru) {
            $beaPenmaru->delete();
        }

        return "Data Penerima Beasiswa sudah di rollback";
    }
}
