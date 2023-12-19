<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBeasiswaPmb extends Model
{
    use HasFactory, Compoships;

    protected $table = 'BOBBY21.V_JNS_BEAPMB';

    public $timestamps = false;

    public $incrementing = false;


    // RELATIONSHIP
    public function jns_bea_aak()
    {
        return $this->hasOne(JenisBeasiswaAak::class, 'jns_beasiswa_penmaru', 'kd_jenis');
    }

    public function syarat()
    {
        return $this->hasMany(SyaratBeasiswa::class, 'jenis_beasiswa', 'kd_jenis');
    }
}
