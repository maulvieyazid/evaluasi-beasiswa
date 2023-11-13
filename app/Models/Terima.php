<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terima extends Model
{
    use HasFactory, Compoships;

    protected $table = 'BOBBY21.V_TERIMA';

    public $timestamps = false;

    public $incrementing = false;


    /*
     | Fungsi ini digunakan untuk mengambil nama relasi jenis beasiswa
     | dikarenakan kolom vbeasiswa ada 4, dan masing2 nya bisa direlasikan dengan model JenisBeasiswaPmb
     | maka daripada meload ke 4 relasi, lebih baik ambil nama relasi nya saja sesuai dengan nilai kolom pilihan_ke
     | nantinya nama ini bisa dipanggil menggunakan fungsi load() ataupun langsung seperti memanggil kolom pada umumnya
     */
    public static function getNamaRelasiJnsBeaPmb($pilihan_ke)
    {
        return 'jenis_beasiswa_pmb' . $pilihan_ke;
    }


    // RELATIONSHIP
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function jenis_beasiswa_pmb1()
    {
        return $this->belongsTo(JenisBeasiswaPmb::class, 'vbeasiswa1', 'kd_jenis');
    }

    public function jenis_beasiswa_pmb2()
    {
        return $this->belongsTo(JenisBeasiswaPmb::class, 'vbeasiswa2', 'kd_jenis');
    }

    public function syarat_peserta()
    {
        return $this->hasMany(SyaratPesertaBeasiswa::class, ['mhs_nim', 'smt'], ['nim', 'smt']);
    }

    public function kesimpulan_beasiswa()
    {
        return $this->hasMany(KesimpulanBeasiswa::class, ['mhs_nim', 'smt'], ['nim', 'smt']);
    }




    public static function queryPenerimaBeasiswa()
    {
        $query = <<<SQL
                WITH SMT AS (
                        SELECT * FROM BOBBY21.V_SMT
                        WHERE FAK_ID = '41010'
                    ),
                    NIM_MHS_AKTIF AS (
                        SELECT MHS_NIM FROM BOBBY21.V_HISMF
                        WHERE NVL(STS_MHS,'X') NOT IN ('N','A','L','O')
                        AND SEMESTER = :SMT
                        /* AND SEMESTER = (SELECT SMT_YAD FROM SMT) */
                    ),
                    MHS AS (
                        SELECT NIM, NO_TEST, NAMA
                        FROM BOBBY21.V_MHS
                        WHERE nim IN (SELECT * FROM NIM_MHS_AKTIF)
                    ),
                    PENERIMA_BEA AS (
                        SELECT * FROM BOBBY21.V_TERIMA
                        WHERE VNOTEST IN (SELECT NO_TEST FROM MHS)
                        AND (
                                (VBEASISWA1 IS NOT NULL AND VBEASISWA1 != 0)
                                OR
                                (VBEASISWA2 IS NOT NULL AND VBEASISWA2 != 0)
                                OR
                                (VBEASISWA3 IS NOT NULL AND VBEASISWA3 != 0)
                                OR
                                (VBEASISWA4 IS NOT NULL AND VBEASISWA4 != 0)
                            )
                    )
                SELECT pb.*, m.NAMA, m.NIM, ppmb.PILIHAN_KE, :SMT AS SMT
                FROM PENERIMA_BEA pb
                JOIN MHS m ON pb.VNOTEST = m.NO_TEST
                JOIN BOBBY21.V_PILIHAN_PMB ppmb ON ppmb.NO_TEST = pb.VNOTEST AND ppmb.KD_JUR_PMB = SUBSTR(m.NIM, 3, 5)
                ORDER BY m.NIM ASC
        SQL;

        return $query;
    }
}
