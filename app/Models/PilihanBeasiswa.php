<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_BEASISWA_PILIHAN';

    public $timestamps = false;

    public $incrementing = false;
}
