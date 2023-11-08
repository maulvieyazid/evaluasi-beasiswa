<?php

namespace App\Http\Controllers;

use App\Models\SyaratPesertaBeasiswa;
use Illuminate\Http\Request;

class SyaratPesertaBeasiswaController extends Controller
{
    function utilDelete($mhs_nim, $jns_beasiswa, $smt, $kd_syarat)
    {
        SyaratPesertaBeasiswa::query()
            ->where('mhs_nim', $mhs_nim)
            ->where('jns_beasiswa', $jns_beasiswa)
            ->where('smt', $smt)
            ->where('kd_syarat', $kd_syarat)
            ->first()
            ->delete();

        return "Data Syarat Peserta Beasiswa berhasil dihapus";
    }
}
