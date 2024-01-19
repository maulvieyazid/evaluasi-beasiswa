<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\JenisBeasiswaPmb;
use App\Models\SyaratBeasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SyaratBeasiswaController extends Controller
{
    public function index()
    {
        $semuaBeasiswa = JenisBeasiswaPmb::query()
            ->withCount('syarat')
            ->orderBy('kd_jenis', 'desc')
            ->get();

        return view('master-syarat-beasiswa', compact('semuaBeasiswa'));
    }

    public function detail($kd_jenis)
    {
        $beasiswa = JenisBeasiswaPmb::where('kd_jenis', $kd_jenis)->first();

        $semuaSyarat = SyaratBeasiswa::query()
            ->where('jenis_beasiswa', $kd_jenis)
            ->with('departemen:kode,nama')
            ->withCount('syarat_peserta as terikat_syarat_peserta')
            ->orderBy('kd_syarat')
            ->get();

        return view('detil-master-syarat-beasiswa', compact('beasiswa', 'semuaSyarat'));
    }


    public function updateJson(Request $req)
    {
        $encSyarat = Crypt::decryptString($req->encSyarat);

        $encSyarat = json_decode($encSyarat, false);

        if (!$req->nm_syarat) return abort(400, 'Nama Syarat tidak boleh kosong');


        // Lakukan validasi pada data request
        [
            'baca_nilai'      => $baca_nilai,
            'nil_min'         => $nil_min,
            'bagian_validasi' => $bagian_validasi,
        ] = $this->validasiDataSyarat($req);


        // Ambil syarat beasiswa yg sesuai dengan jenis beasiswa dan kode syarat dari data enkripsi
        $syarat = SyaratBeasiswa::query()
            ->where('jenis_beasiswa', $encSyarat->jenis_beasiswa)
            ->where('kd_syarat', $encSyarat->kd_syarat)
            ->first();

        // Update syarat beasiswa
        $syarat->update([
            'nm_syarat'       => $req->nm_syarat,
            'nil_min'         => $nil_min,
            'bagian_validasi' => $bagian_validasi,
            'baca_nilai'      => $baca_nilai,
        ]);

        return response()->json([
            'status' => 'success',
            'syarat' => $syarat,
        ]);
    }

    private function validasiDataSyarat($req)
    {
        // Validasi value baca_nilai
        $allowedBacaNilai = [
            SyaratBeasiswa::IPS,
            SyaratBeasiswa::STSKULIAH,
        ];
        // Kalo value nya gk ada di salah satu item array, maka jadikan null saja
        $baca_nilai = in_array($req->baca_nilai, $allowedBacaNilai) ? $req->baca_nilai : null;

        // Validasi value nil_min, hanya boleh nilai positif
        $nil_min = abs($req->nil_min);

        // Validasi value bagian_validasi
        $allowedBagianValidasi = [
            Departemen::KEUANGAN,
            Departemen::KMHS,
        ];
        // Kalo value bagian_validasi nya bukan salah satu item array, maka default kan ke keuangan saja
        $bagian_validasi = in_array($req->bagian_validasi, $allowedBagianValidasi) ? $req->bagian_validasi : Departemen::KEUANGAN;


        return compact('baca_nilai', 'nil_min', 'bagian_validasi');
    }


    function storeJson(Request $req)
    {
        $encSyarat = Crypt::decryptString($req->encSyarat);

        $encSyarat = json_decode($encSyarat, false);

        if (!$req->nm_syarat) return abort(400, 'Nama Syarat tidak boleh kosong');


        // Lakukan validasi pada data request
        [
            'baca_nilai'      => $baca_nilai,
            'nil_min'         => $nil_min,
            'bagian_validasi' => $bagian_validasi,
        ] = $this->validasiDataSyarat($req);


        // Generate kd_syarat
        $kd_syarat = SyaratBeasiswa::max('kd_syarat') + 1;

        $syarat = SyaratBeasiswa::create([
            'jenis_beasiswa'  => $encSyarat->kd_jenis,
            'kd_syarat'       => $kd_syarat,
            'nm_syarat'       => $req->nm_syarat,
            'nil_min'         => $nil_min,
            'bagian_validasi' => $bagian_validasi,
            'baca_nilai'      => $baca_nilai,
        ]);

        $newEncSyarat = json_encode($syarat->only(['kd_syarat', 'jenis_beasiswa']));
        $newEncSyarat = Crypt::encryptString($newEncSyarat);

        return response()->json([
            'status'    => 'success',
            'syarat'    => $syarat,
            'encSyarat' => $newEncSyarat,
        ]);
    }


    public function destroyJson(Request $req)
    {
        $encSyarat = Crypt::decryptString($req->encSyarat);

        $encSyarat = json_decode($encSyarat, false);

        // Ambil Syarat Beasiswa dengan jenis_beasiswa dan kd_syarat tertentu
        $syarat = SyaratBeasiswa::query()
            ->where('jenis_beasiswa', $encSyarat->jenis_beasiswa)
            ->where('kd_syarat', $encSyarat->kd_syarat)
            ->withCount('syarat_peserta as terikat_syarat_peserta')
            ->first();

        $respon = ['status' => 'success'];

        // Kalau syarat nya gk ada, maka langsung return saja
        if (!$syarat) return response()->json($respon);

        // Kalau masih terikat dengan Syarat Peserta Beasiswa, maka langsung return juga
        if ($syarat->terikat_syarat_peserta) return abort(400, 'Tidak bisa menghapus syarat yang sudah terisi oleh Evaluator');

        // Hapus Syarat Beasiswa
        $syarat->delete();

        return response()->json($respon);
    }
}
