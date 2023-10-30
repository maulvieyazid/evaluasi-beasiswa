<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_JNS_BEAPMB';

    public $timestamps = false;

    public $incrementing = false;
}
