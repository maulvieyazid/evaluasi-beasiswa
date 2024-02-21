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

    protected $appends = [
        'jns_beasiswa',
    ];

    // ACCESSOR
    /*
     | Accessor ini untuk menambahkan atribut "jns_beasiswa", yang menjadi atribut untuk direlasikan dengan model-model yang lain
     | seperti relasi ke model JenisBeasiswaPmb, SimpulBagian, dll.
    */
    public function getJnsBeasiswaAttribute()
    {
        // Rangkai nama kolom vbeasiswa yang dipakai
        // NOTE : kolom "vbeasiswa" ada 4, yaitu vbeasiswa1, vbeasiswa2, vbeasiswa3, vbeasiswa4
        // untuk menentukan kolom mana yang dipakai, maka tinggal menggabungkan nya dengan kolom "pilihan_ke"
        $kolom_vbeasiswa = "vbeasiswa{$this->pilihan_ke}";

        // Ambil nilai dari kolom vbeasiswa yang dipakai
        return $this->{$kolom_vbeasiswa};
    }




    // RELATIONSHIP
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function his_mf()
    {
        return $this->hasMany(HisMf::class, 'mhs_nim', 'nim');
    }

    public function jenis_beasiswa_pmb()
    {
        return $this->belongsTo(JenisBeasiswaPmb::class, 'jns_beasiswa', 'kd_jenis');
    }

    public function syarat_peserta()
    {
        return $this->hasMany(SyaratPesertaBeasiswa::class, ['mhs_nim', 'smt'], ['nim', 'smt']);
    }

    public function kesimpulan_beasiswa()
    {
        return $this->hasMany(KesimpulanBeasiswa::class, ['mhs_nim', 'smt'], ['nim', 'smt']);
    }

    public function simpul_bagian()
    {
        return $this->hasMany(SimpulBagian::class, ['mhs_nim', 'smt', 'jns_beasiswa'], ['nim', 'smt', 'jns_beasiswa']);
    }




    public static function queryPenerimaBeasiswa()
    {
        $sts_tidak_lolos = KesimpulanBeasiswa::TIDAK_LOLOS;

        $query = <<<SQL
                WITH NIM_MHS_AKTIF AS (
                        SELECT MHS_NIM FROM BOBBY21.V_HISMF
                        WHERE NVL(STS_MHS,'X') NOT IN ('N','A','L','O')
                        AND SEMESTER = :SMT
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
                SELECT pb.*, m.NAMA, m.NIM, ppmb.PILIHAN_KE, :SMT AS SMT,
                        (
                            CASE
                                WHEN EXISTS (
                                    SELECT 1 FROM BOBBY21.V_BEASISWA_KESIMPULAN vbk
                                    WHERE vbk.MHS_NIM = m.NIM AND vbk.STATUS = '$sts_tidak_lolos'
                                )
                                THEN 1 ELSE 0
                            END
                        ) AS IS_BEASISWA_DICABUT
                FROM PENERIMA_BEA pb
                JOIN MHS m ON pb.VNOTEST = m.NO_TEST
                JOIN BOBBY21.V_PILIHAN_PMB ppmb ON ppmb.NO_TEST = pb.VNOTEST AND ppmb.KD_JUR_PMB = SUBSTR(m.NIM, 3, 5)
                ORDER BY m.NIM ASC
        SQL;

        return $query;
    }
}
