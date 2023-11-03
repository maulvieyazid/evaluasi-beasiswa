<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KesimpulanBeasiswa extends Model
{
    use HasFactory;

    const LOLOS = 'Y';
    const TIDAK_LOLOS = 'T';


    protected $table = 'BOBBY21.V_BEASISWA_KESIMPULAN';

    public $timestamps = false;

    public $incrementing = false;
}
