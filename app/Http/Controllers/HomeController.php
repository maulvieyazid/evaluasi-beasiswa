<?php

namespace App\Http\Controllers;

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

    public function getJmlPenerimaPerJenisBeasiswa($smt)
    {
        $data = KesimpulanBeasiswa::query()
            ->with('jenis_beasiswa_pmb')
            ->where('status', KesimpulanBeasiswa::LOLOS)
            ->where('smt', $smt)
            ->get();

        // Hitung jumlah penerima berdasarkan keterangan dari jenis beasiswa
        $data = $data->countBy('jenis_beasiswa_pmb.keterangan');

        $data = $data
            // Lakukan map untuk membentuk array yg sesuai dengan series chart
            ->map(function ($item, $key) {
                $out = [
                    'x' => $key,
                    'y' => $item,
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
}
