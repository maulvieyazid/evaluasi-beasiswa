<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_MHS';

    public $timestamps = false;

    public $incrementing = false;

    public static function getNimSaudara($nim)
    {
        $mhs = Mahasiswa::where('nim', $nim)
            ->select('nim', 'nama', 'no_test')
            ->with('pilihan_beasiswa')
            ->first();

        // Kalau mhs nya tidak ada, maka return null
        if (!$mhs) return null;

        // Kalau pilihan_beasiswa nya tidak ada, maka return null
        if (!$mhs->pilihan_beasiswa) return null;

        return $mhs->pilihan_beasiswa->nim_keluarga;
    }


    // RELATIONSHIP
    public function pilihan_beasiswa()
    {
        return $this->hasOne(PilihanBeasiswa::class, 'no_test', 'no_test');
    }
}
