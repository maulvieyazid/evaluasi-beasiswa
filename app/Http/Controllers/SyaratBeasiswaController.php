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




    public function utilInsert()
    {
        // VARIABEL INI JANGAN DIUBAH !!!
        $i = 1;

        // Data untuk di insert
        // YANG DIUBAH2 YG DISINI AJA !!!
        $data = [
            [
                'jenis_beasiswa'  => 25,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Bersedia mematuhi peraturan yang berlaku di Universitas Dinamika.',
                'nil_min'         => 1,
                'bagian_validasi' => Departemen::KMHS,
            ],
            [
                'jenis_beasiswa'  => 25,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Bersedia berkontribusi dan terlibat aktif dalam kegiatan Universitas Dinamika dan Bagian Penerimaan Mahasiswa Baru.',
                'nil_min'         => 1,
                'bagian_validasi' => Departemen::KMHS,
            ],
            [
                'jenis_beasiswa'  => 25,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Evaluasi Indeks Prestasi Semester (IPS) yang harus dicapai setiap semester >= 3.00.',
                'nil_min'         => 3.00,
                'bagian_validasi' => Departemen::KEUANGAN,
            ],
            [
                'jenis_beasiswa'  => 25,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Tidak diperkenankan untuk: (a) pindah ke program studi lain, (b) mengajukan cuti semester.',
                'nil_min'         => 1,
                'bagian_validasi' => Departemen::KEUANGAN,
            ],
            [
                'jenis_beasiswa'  => 14,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Bersedia mematuhi peraturan yang berlaku di Universitas Dinamika.',
                'nil_min'         => 1,
                'bagian_validasi' => Departemen::KMHS,
            ],
            [
                'jenis_beasiswa'  => 14,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Bersedia berkontribusi dan terlibat aktif dalam kegiatan Universitas Dinamika dan Bagian Penerimaan Mahasiswa Baru.',
                'nil_min'         => 1,
                'bagian_validasi' => Departemen::KMHS,
            ],
            [
                'jenis_beasiswa'  => 14,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Evaluasi Indeks Prestasi Semester (IPS) yang harus dicapai setiap semester >= 3.00.',
                'nil_min'         => 3.00,
                'bagian_validasi' => Departemen::KEUANGAN,
            ],
            [
                'jenis_beasiswa'  => 14,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Tidak diperkenankan untuk: (a) pindah ke program studi lain, (b) mengajukan cuti semester.',
                'nil_min'         => 1,
                'bagian_validasi' => Departemen::KEUANGAN,
            ],
            [
                'jenis_beasiswa'  => 14,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Tergabung menjadi anggota Unit Kegiatan Mahasiswa (UKM) yang relevan.',
                'nil_min'         => 1,
                'bagian_validasi' => Departemen::KMHS,
            ],
            [
                'jenis_beasiswa'  => 14,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Bersedia berpartisipasi dalam acara Universitas Dinamika atau mewakili Universitas Dinamika dalam perlombaan.',
                'nil_min'         => 1,
                'bagian_validasi' => Departemen::KMHS,
            ],
        ];

        // Proses insert
        foreach ($data as $syarat) {
            $syarat = (object) $syarat;

            SyaratBeasiswa::updateOrCreate(
                // Ini WHERE nya
                [
                    'jenis_beasiswa'  => $syarat->jenis_beasiswa,
                    'kd_syarat'       => $syarat->kd_syarat,

                ],
                // Ini SET nya
                [
                    'nm_syarat'       => $syarat->nm_syarat,
                    'nil_min'         => $syarat->nil_min,
                    'bagian_validasi' => $syarat->bagian_validasi,
                ]
            );
        }

        return "Data Syarat Beasiswa berhasil diinsert";
    }

    // Fungsi ini digunakan untuk mengupdate satu data saja
    public function utilUpdate()
    {
        // Untuk mengupdate, ubah saja isian data ini dengan data di database yang mau diubah
        $data = [
            'jenis_beasiswa'  => 25,
            'kd_syarat'       => 3,
            'nm_syarat'       => 'Evaluasi Indeks Prestasi Semester (IPS) yang harus dicapai setiap semester >= 3.00.',
            'nil_min'         => 3.00,
            'bagian_validasi' => Departemen::KEUANGAN,
        ];

        /*
        | Yang dibawah ini gk perlu diubah2
        | ---------------------------------------------------
        */
        $data = (object) $data;

        $syarat = SyaratBeasiswa::query()
            ->where('jenis_beasiswa', $data->jenis_beasiswa)
            ->where('kd_syarat', $data->kd_syarat)
            ->first();

        $syarat->update([
            'nm_syarat'       => $data->nm_syarat,
            'nil_min'         => $data->nil_min,
            'bagian_validasi' => $data->bagian_validasi,
        ]);

        return "Data Syarat Beasiswa berhasil diupdate";
    }


    /* public function utilDelete($kd_jns_bea_pmb, $kd_syarat)
    {
        SyaratBeasiswa::where('jenis_beasiswa', $kd_jns_bea_pmb)
            ->where('kd_syarat', $kd_syarat)
            ->first()
            ->delete();

        return "Data Syarat Beasiswa berhasil dihapus";
    } */
}
