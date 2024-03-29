<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HisMf extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_HISMF';

    public $timestamps = false;

    public $incrementing = false;

    protected $appends = ['nama_status'];


    // ACCESSOR
    public function getNamaStatusAttribute()
    {
        $nama = 'Aktif';

        $sts = $this->sts_mhs ?? null;

        // Kalo sts nya null, langsung return $nama
        if (!$sts) return $nama;

        switch ($sts) {
            case 'S':
                $nama = 'Tidak Registrasi';
                break;

            case 'C':
                $nama = 'Cuti';
                break;

            case 'T':
                $nama = 'Tugas Akhir';
                break;
        }

        return $nama;
    }


    public static function isMhsMasihAktif($nim)
    {
        return !self::isMhsSudahTidakAktif($nim);
    }

    public static function isMhsSudahTidakAktif($nim)
    {
        // Periksa di HIS_MF, apakah nim ini memiliki status N,A,L,O
        $isTidakAktif = HisMf::where('mhs_nim', $nim)
            ->whereIn('sts_mhs', ['N', 'A', 'L', 'O'])
            ->count();

        // Kalo ada, maka return true
        return $isTidakAktif ? true : false;
    }
}
