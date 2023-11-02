<?php

namespace App\Http\Controllers;

use App\Models\SyaratBeasiswa;
use Illuminate\Http\Request;

class SyaratBeasiswaController extends Controller
{
    const KMHS = 9;
    const KEUANGAN = 28;

    public function utilInsert()
    {
        // Untuk mengambil kd_syarat maksimal di DB lalu di plus 1
        // INI JANGAN DIUBAH2 YA !!
        $i = SyaratBeasiswa::max('kd_syarat') + 1;

        // Data untuk di insert
        // YANG DIUBAH2 YG DISINI AJA !!!
        $data = [
            [
                'jenis_beasiswa'  => 25,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Bersedia mematuhi peraturan yang berlaku di Universitas Dinamika.',
                'nil_min'         => 1,
                'bagian_validasi' => self::KMHS,
            ],
            [
                'jenis_beasiswa'  => 25,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Bersedia berkontribusi dan terlibat aktif dalam kegiatan Universitas Dinamika dan Bagian Penerimaan Nahasiswa Baru.',
                'nil_min'         => 1,
                'bagian_validasi' => self::KMHS,
            ],
            [
                'jenis_beasiswa'  => 25,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Evaluasi Indeks Prestasi Semester (IPS) yang harus dicapai setiap semester >= 3.00.',
                'nil_min'         => 3.00,
                'bagian_validasi' => self::KEUANGAN,
            ],
            [
                'jenis_beasiswa'  => 25,
                'kd_syarat'       => $i++,
                'nm_syarat'       => 'Tidak diperkenankan untuk: (a) pindah ke program studi lain, (b) mengajukan cuti semester.',
                'nil_min'         => 1,
                'bagian_validasi' => self::KEUANGAN,
            ],
        ];

        // Proses insert
        foreach ($data as $syarat) {
            $syarat = (object) $syarat;

            SyaratBeasiswa::create([
                'jenis_beasiswa'  => $syarat->jenis_beasiswa,
                'kd_syarat'       => $syarat->kd_syarat,
                'nm_syarat'       => $syarat->nm_syarat,
                'nil_min'         => $syarat->nil_min,
                'bagian_validasi' => $syarat->bagian_validasi,
            ]);
        }

        return "Data Syarat Beasiswa berhasil diinsert";
    }

    public function utilUpdate()
    {
        // Untuk mengupdate, ubah saja isian data ini dengan data di database yang mau diubah
        $data = [
            'jenis_beasiswa'  => 25,
            'kd_syarat'       => 3,
            'nm_syarat'       => 'Evaluasi Indeks Prestasi Semester (IPS) yang harus dicapai setiap semester >= 3.00.',
            'nil_min'         => 3.00,
            'bagian_validasi' => self::KEUANGAN,
        ];

        $data = (object) $data;

        $syarat = SyaratBeasiswa::query()
            ->where('jenis_beasiswa', $data->jenis_beasiswa)
            ->where('kd_syarat', $data->kd_syarat)
            ->first();

        $syarat->update([
            'nm_syarat'       => 'Evaluasi Indeks Prestasi Semester (IPS) yang harus dicapai setiap semester >= 3.00.',
            'nil_min'         => 3.00,
            'bagian_validasi' => self::KEUANGAN,
        ]);

        return "Data Syarat Beasiswa berhasil diupdate";
    }


    public function utilDelete($jenis_beasiswa, $kd_syarat)
    {
        SyaratBeasiswa::where('jenis_beasiswa', $jenis_beasiswa)
            ->where('kd_syarat', $kd_syarat)
            ->first()
            ->delete();

        return "Data Syarat Beasiswa berhasil dihapus";
    }
}
