<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SmartController extends Controller
{
    public function kriteria()
    {
        $kriteria = DB::table('smart_kriteria')->get();
        return view('smart.kriteria', compact('kriteria'));
    }

    public function alternatif()
    {
        $alternatif = DB::table('smart_alternatif')->get();
        return view('smart.alternatif', compact('alternatif'));
    }

    public function penilaian()
    {
        $penilaian = DB::table('smart_penilaian')
            ->join(
                'smart_alternatif',
                'smart_penilaian.id_alternatif',
                '=',
                'smart_alternatif.id'
            )
            ->select(
                'smart_penilaian.*',
                'smart_alternatif.nama_es as nama_es'
            )
            ->get();

        return view('smart.penilaian', compact('penilaian'));
    }
   public function proses()
{
    $kriteria = DB::table('smart_kriteria')->get();

    $totalBobot = $kriteria->sum('bobot');

    // Hitung normalisasi bobot untuk setiap kriteria
    $kriteria = $kriteria->map(function ($item) use ($totalBobot) {
        $item->normalisasi = $totalBobot > 0
            ? round($item->bobot / $totalBobot, 2)
            : 0;
        return $item;
    });

    $penilaian = DB::table('smart_penilaian')
        ->join(
            'smart_alternatif',
            'smart_penilaian.id_alternatif',
            '=',
            'smart_alternatif.id'
        )
        ->select(
            'smart_penilaian.*',
            'smart_alternatif.nama_es as nama_es'
        )
        ->get();

    $alternatif = DB::table('smart_alternatif')->get();

    return view('smart.proses', compact('kriteria', 'alternatif', 'penilaian'));
}
    public function hasil()
    {
        $kriteria = DB::table('smart_kriteria')->get();
        $totalBobot = $kriteria->sum('bobot');

        $normalisasi = [];

        foreach ($kriteria as $item) {
            $normalisasi[$item->kode_kriteria] = $item->bobot / $totalBobot;
        }

        $penilaian = DB::table('smart_penilaian')
            ->join(
                'smart_alternatif',
                'smart_penilaian.id_alternatif',
                '=',
                'smart_alternatif.id'
            )
            ->select(
                'smart_penilaian.*',
                'smart_alternatif.nama_es as nama_es'
            )
            ->get();

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

        usort($hasil, fn($a, $b) => $b['nilai_akhir'] <=> $a['nilai_akhir']);

        DB::table('smart_hasil')->truncate();

        foreach ($hasil as $index => $item) {

            $alternatif = DB::table('smart_alternatif')
                ->where('nama_es', $item['nama_es'])
                ->first();
            if (!$alternatif) {
                continue;
            }

            DB::table('smart_hasil')->insert([
                'id_alternatif' => $alternatif->id,
                'nilai_akhir' => $item['nilai_akhir'],
                'ranking' => $index + 1,
            ]);
        }

        return view('smart.hasil', compact('hasil'));
    }
}
