<?php

namespace App\Http\Controllers;

use App\Models\KesimpulanBeasiswa;
use Illuminate\Http\Request;

class KesimpulanBeasiswaController extends Controller
{
    function utilDelete($mhs_nim, $jns_beasiswa, $smt)
    {
        KesimpulanBeasiswa::query()
            ->where('mhs_nim', $mhs_nim)
            ->where('jns_beasiswa', $jns_beasiswa)
            ->where('smt', $smt)
            ->first()
            ->delete();

        return "Data Kesimpulan Beasiswa berhasil dihapus";
    }
}
