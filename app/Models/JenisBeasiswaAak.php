<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBeasiswaAak extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_JNS_BEA';

    public $timestamps = false;

    public $incrementing = false;


    // RELATIONSHIP
    public function jns_bea_pmb()
    {
        return $this->belongsTo(JenisBeasiswaPmb::class, 'jns_beasiswa_penmaru', 'kd_jenis');
    }
}
