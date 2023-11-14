<?php

namespace App\Http\Controllers;

use App\Models\KesimpulanBeasiswa;
use Illuminate\Http\Request;

class KesimpulanBeasiswaController extends Controller
{
    function utilDelete($mhs_nim, $kd_jns_bea_pmb, $smt)
    {
        KesimpulanBeasiswa::query()
            ->where('mhs_nim', $mhs_nim)
            ->where('jns_beasiswa', $kd_jns_bea_pmb)
            ->where('smt', $smt)
            ->first()
            ->delete();

        return "Data Kesimpulan Beasiswa berhasil dihapus";
    }
}
