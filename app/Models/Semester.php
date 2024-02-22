<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_SMT';

    public $timestamps = false;

    public $incrementing = false;


    public static function getSmtSelanjutnya($smt = null)
    {
        if ($smt == null) return "Mohon isikan parameter smt.";

        // Kalo semester nya tidak 3 digit, maka langsung kembalikan semester nya
        if (strlen($smt) != 3) return $smt;

        // Ubah smt nya jadi int
        $smt = (int) $smt;

        // Ambil digit terakh1r semester
        $digit_terakhir = $smt % 10;

        // Nilai default untuk semester selanjutnya adalah semester
        $smt_selanjutnya = $smt;

        // Kalau digit terakhir nya adalah 1, maka untuk semester selanjutnya, tinggal menambahkan semester dengan 1
        // Misal : 231 => 232
        if ($digit_terakhir == 1) $smt_selanjutnya = $smt + 1;

        // Kalau digit terakhir nya adalah 1, maka untuk semester selanjutnya, tinggal menambahkan semester dengan 9
        // Misal : 242 => 251
        if ($digit_terakhir == 2) $smt_selanjutnya = $smt + 9;

        return $smt_selanjutnya;
    }
}
