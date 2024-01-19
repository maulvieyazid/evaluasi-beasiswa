<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    const KMHS = 9;

    const KEUANGAN = 28;

    const PENMARU = 11;

    const AAK = 4;

    protected $table = 'V_DEPARTEMEN1';

    public $timestamps = false;

    public $incrementing = false;
}
