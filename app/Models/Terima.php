<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terima extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_TERIMA';

    public $timestamps = false;

    public $incrementing = false;


    public static function getNamaRelasiJnsBea($pilihan_ke)
    {
        return 'jenis_beasiswa' . $pilihan_ke;
    }


    // RELATIONSHIP
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function jenis_beasiswa1()
    {
        return $this->belongsTo(JenisBeasiswa::class, 'vbeasiswa1', 'kd_jenis');
    }

    public function jenis_beasiswa2()
    {
        return $this->belongsTo(JenisBeasiswa::class, 'vbeasiswa2', 'kd_jenis');
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
                                VBEASISWA1 IS NOT NULL
                                OR VBEASISWA2 IS NOT NULL
                                OR VBEASISWA3 IS NOT NULL
                                OR VBEASISWA4 IS NOT NULL
                            )
                    )
                SELECT pb.*, m.NAMA, m.NIM, ppmb.PILIHAN_KE
                FROM PENERIMA_BEA pb
                JOIN MHS m ON pb.VNOTEST = m.NO_TEST
                JOIN BOBBY21.V_PILIHAN_PMB ppmb ON ppmb.NO_TEST = pb.VNOTEST AND ppmb.KD_JUR_PMB = SUBSTR(m.NIM, 3, 5)
        SQL;

        return $query;
    }
}
