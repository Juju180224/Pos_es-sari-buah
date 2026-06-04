<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SmartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATA KRITERIA
    |--------------------------------------------------------------------------
    */

    public function kriteria()
    {
        $kriteria = DB::table('smart_kriteria')->get();

        return view('smart.kriteria', compact('kriteria'));
    }

    /*
    |--------------------------------------------------------------------------
    | DATA ALTERNATIF
    |--------------------------------------------------------------------------
    */

    public function alternatif()
    {
        $alternatif = DB::table('smart_alternatif')->get();

        return view('smart.alternatif', compact('alternatif'));
    }

    /*
    |--------------------------------------------------------------------------
    | PENILAIAN
    |--------------------------------------------------------------------------
    */

    public function penilaian()
    {
        $penilaian = DB::table('smart_penilaian')
            ->join('smart_alternatif', 'smart_penilaian.id_alternatif', '=', 'smart_alternatif.id_alternatif')
            ->select(
                'smart_penilaian.*',
                'smart_alternatif.nama_es'
            )
            ->get();

        return view('smart.penilaian', compact('penilaian'));
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES SMART
    |--------------------------------------------------------------------------
    */

    public function proses()
    {
        $kriteria = DB::table('smart_kriteria')->get();
        $alternatif = DB::table('smart_alternatif')->get();
        $penilaian = DB::table('smart_penilaian')->get();

        return view('smart.proses', compact(
            'kriteria',
            'alternatif',
            'penilaian'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | HASIL SMART
    |--------------------------------------------------------------------------
    */

    public function hasil()
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA KRITERIA
        |--------------------------------------------------------------------------
        */

        $kriteria = DB::table('smart_kriteria')->get();

        /*
        |--------------------------------------------------------------------------
        | TOTAL BOBOT
        |--------------------------------------------------------------------------
        */

        $totalBobot = $kriteria->sum('bobot');

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI BOBOT
        |--------------------------------------------------------------------------
        */

        $normalisasi = [];

        foreach ($kriteria as $item) {

            $normalisasi[$item->kode_kriteria] =
                $item->bobot / $totalBobot;
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PENILAIAN
        |--------------------------------------------------------------------------
        */

        $penilaian = DB::table('smart_penilaian')
            ->join(
                'smart_alternatif',
                'smart_penilaian.id_alternatif',
                '=',
                'smart_alternatif.id_alternatif'
            )
            ->select(
                'smart_penilaian.*',
                'smart_alternatif.nama_es'
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | HITUNG NILAI AKHIR SMART
        |--------------------------------------------------------------------------
        */

        $hasil = [];

        foreach ($penilaian as $item) {

            $nilaiAkhir =
                ($item->c1 * $normalisasi['C1']) +
                ($item->c2 * $normalisasi['C2']) +
                ($item->c3 * $normalisasi['C3']) +
                ($item->c4 * $normalisasi['C4']) +
                ($item->c5 * $normalisasi['C5']);

            $hasil[] = [
                'nama_es' => $item->nama_es,
                'nilai_akhir' => round($nilaiAkhir, 2)
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SORTING RANKING
        |--------------------------------------------------------------------------
        */

        usort($hasil, function ($a, $b) {
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        DB::table('smart_hasil')->truncate();

        foreach ($hasil as $index => $item) {

            $alternatif = DB::table('smart_alternatif')
                ->where('nama_es', $item['nama_es'])
                ->first();

            DB::table('smart_hasil')->insert([
                'id_alternatif' => $alternatif->id_alternatif,
                'nilai_akhir' => $item['nilai_akhir'],
                'ranking' => $index + 1,
            ]);
        }

        return view('smart.hasil', compact('hasil'));
    }
}
