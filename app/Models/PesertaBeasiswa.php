<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_BEASISWA_SYARAT_PESERTA';

    public $timestamps = false;

    public $incrementing = false;
}
