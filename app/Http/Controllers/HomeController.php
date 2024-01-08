<?php

namespace App\Http\Controllers;

use App\Models\JenisBeasiswaPmb;
use App\Models\KesimpulanBeasiswa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $semuaSmt = KesimpulanBeasiswa::query()
            ->select('smt')
            ->distinct()
            ->orderBy('smt', 'desc')
            ->get();

        return view('home', compact('semuaSmt'));
    }

    public function getJmlPenerimaPerSmt()
    {
        $data = KesimpulanBeasiswa::query()
            ->selectRaw('smt, count(*) AS jumlah, smt AS x, count(*) AS y')
            ->groupBy('smt')
            ->where('status', KesimpulanBeasiswa::LOLOS)
            ->orderBy('smt', 'desc')
            ->get();

        // NOTE : Ini adalah cara alternatif bila selectRaw nya bermasalah
        /* $data = $data->map(function ($item, $key) {
            $item->fill([
                'x' => $item->smt,
                'y' => $item->jumlah,
            ]);

            return $item;
        }); */

        // Permintaan nya adalah menampilkan 3 tahun terakhir, sehingga diambil 6 semester saja
        $data = $data->take(6);

        return response()->json($data);

        /* return response()->json([
            ['x' => '202', 'y' => '40'],
            ['x' => '211', 'y' => '30'],
            ['x' => '212', 'y' => '40'],
            ['x' => '221', 'y' => '35'],
            ['x' => '222', 'y' => '50'],
            ['x' => '231', 'y' => '49'],
        ]); */
    }

    public function getDetailJmlPenerimaPerSmt($smt)
    {
        $semuaPenerima = KesimpulanBeasiswa::query()
            ->where('smt', $smt)
            ->where('status', KesimpulanBeasiswa::LOLOS)
            ->with('mahasiswa')
            ->orderBy('mhs_nim')
            ->orderBy('jns_beasiswa')
            ->get();

        return view('components.detail-jml-penerima-bea-per-smt', compact('semuaPenerima'));
    }



    /* ======================================================================================================== */



    public function getJmlPenerimaPerJenisBeasiswa($smt)
    {
        $jenis_bea = JenisBeasiswaPmb::select('kd_jenis', 'keterangan')->get();

        $data = KesimpulanBeasiswa::query()
            ->where('status', KesimpulanBeasiswa::LOLOS)
            ->where('smt', $smt)
            ->get();

        // Hitung jumlah penerima berdasarkan keterangan dari jenis beasiswa
        $data = $data->countBy('jns_beasiswa');

        $data = $data
            // Lakukan map untuk membentuk array yg sesuai dengan series chart
            ->map(function ($item, $key) use ($jenis_bea) {
                // Ambil keterangan beasiswa dari $jenis_bea, berdasarkan kd_jenis nya
                $keterangan = $jenis_bea->where('kd_jenis', $key)->first()->keterangan;

                // Atribut yang diperlukan oleh ApexChart adalah 'x' dan 'y', selain dari itu adalah data tambahan
                $out = [
                    'x' => $keterangan,
                    'y' => $item,
                    'kd_jenis' => $key,
                ];

                return $out;
            })
            // Lakukan indeks ulang
            ->values();

        return response()->json($data);

        /* return response()->json([
            [
                'x' => 'Beasiswa Keluarga Besar Universitas Dinamika (Putra/Putri dari Ortu dan Saudara Kandung Alumni Undika/Stikom) 2023',
                'y' => '10'
            ],
            [
                'x' => 'Beasiswa Kuliah 0 Rupiah',
                'y' => '13'
            ],
        ]); */
    }

    public function getDetailJmlPenerimaPerJenisBeasiswa($smt, $kd_jenis)
    {
        $semuaPenerima = KesimpulanBeasiswa::query()
            ->where('smt', $smt)
            ->where('jns_beasiswa', $kd_jenis)
            ->where('status', KesimpulanBeasiswa::LOLOS)
            ->get();

        return view('components.detail-jml-penerima-bea-per-jns-bea', compact('semuaPenerima'));
    }



    /* ======================================================================================================== */



    public function getPrsntsPenerimaAktfGgr($smt)
    {
        $data = KesimpulanBeasiswa::query()
            ->selectRaw('smt, status, count(*) AS jumlah')
            ->groupBy('smt', 'status')
            ->where('smt', $smt)
            ->get();

        // Ambil data 'kesimpulan_beasiswa' yang status nya lolos
        $lolos = $data->where('status', KesimpulanBeasiswa::LOLOS)->first();
        // Kalo gk ada, maka default 0, klo ada, maka ambil nilai jumlah dan cast ke int
        $aktif = !$lolos ? 0 : (int) $lolos->jumlah;

        // Ambil data 'kesimpulan_beasiswa' yang status nya tidak lolos
        $tdk_lolos = $data->where('status', KesimpulanBeasiswa::TIDAK_LOLOS)->first();
        // Kalo gk ada, maka default 0, klo ada, maka ambil nilai jumlah dan cast ke int
        $gugur = !$tdk_lolos ? 0 : (int) $tdk_lolos->jumlah;


        return response()->json(
            [$aktif, $gugur]
        );
    }

    public function getDetailPrsntsPenerimaAktfGgr($smt, $status)
    {
        $semuaPenerima = KesimpulanBeasiswa::query()
            ->where('smt', $smt)
            ->where('status', $status)
            ->orderBy('mhs_nim')
            ->get();

        return view('components.detail-prsnts-penerima-bea-aktif-gugur', compact('semuaPenerima'));
    }
}
