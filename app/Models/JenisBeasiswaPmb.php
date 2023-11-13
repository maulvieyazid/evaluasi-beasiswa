<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBeasiswaPmb extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_JNS_BEAPMB';

    public $timestamps = false;

    public $incrementing = false;


    // RELATIONSHIP
    public function jns_bea_aak()
    {
        return $this->hasOne(JenisBeasiswaAak::class, 'jns_beasiswa_penmaru', 'kd_jenis');
    }
}
