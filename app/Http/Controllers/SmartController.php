<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SmartController extends Controller
{
    public function kriteria()
    {
        $kriteria = DB::table('smart_kriteria')->get();
        return view('smart.kriteria', compact('kriteria'));
    }

    public function storeKriteria(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|max:10',
            'nama_kriteria' => 'required|string|max:100',
            'bobot' => 'required|numeric|min:0',
        ]);

        DB::table('smart_kriteria')->insert([
            'kode_kriteria' => $request->kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('smart.kriteria')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function updateKriteria(Request $request, $id)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|max:10',
            'nama_kriteria' => 'required|string|max:100',
            'bobot' => 'required|numeric|min:0',
        ]);

        DB::table('smart_kriteria')->where('id', $id)->update([
            'kode_kriteria' => $request->kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot,
            'updated_at' => now(),
        ]);

        return redirect()->route('smart.kriteria')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroyKriteria($id)
    {
        DB::table('smart_kriteria')->where('id', $id)->delete();
        return redirect()->route('smart.kriteria')->with('success', 'Kriteria berhasil dihapus.');
    }

    public function alternatif()
    {
        $alternatif = DB::table('smart_alternatif')->get();
        return view('smart.alternatif', compact('alternatif'));
    }

    public function storeAlternatif(Request $request)
    {
        $request->validate([
            'kode_alternatif' => 'nullable|string|max:10',
            'nama_es' => 'required|string|max:100',
        ]);

        DB::table('smart_alternatif')->insert([
            'kode_alternatif' => $request->kode_alternatif,
            'nama_es' => $request->nama_es,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('smart.alternatif')->with('success', 'Alternatif berhasil ditambahkan.');
    }

    public function updateAlternatif(Request $request, $id)
    {
        $request->validate([
            'kode_alternatif' => 'nullable|string|max:10',
            'nama_es' => 'required|string|max:100',
        ]);

        DB::table('smart_alternatif')->where('id', $id)->update([
            'kode_alternatif' => $request->kode_alternatif,
            'nama_es' => $request->nama_es,
            'updated_at' => now(),
        ]);

        return redirect()->route('smart.alternatif')->with('success', 'Alternatif berhasil diperbarui.');
    }

    public function destroyAlternatif($id)
    {
        DB::table('smart_alternatif')->where('id', $id)->delete();
        return redirect()->route('smart.alternatif')->with('success', 'Alternatif berhasil dihapus.');
    }

    public function penilaian()
    {
        $penilaian = DB::table('smart_penilaian')
            ->join('smart_alternatif', 'smart_penilaian.id_alternatif', '=', 'smart_alternatif.id')
            ->select('smart_penilaian.*', 'smart_alternatif.nama_es as nama_es')
            ->get();

        $alternatif = DB::table('smart_alternatif')->get();

        return view('smart.penilaian', compact('penilaian', 'alternatif'));
    }

    public function storePenilaian(Request $request)
    {
        $request->validate([
            'id_alternatif' => 'required|exists:smart_alternatif,id',
            'c1' => 'required|numeric|min:0',
            'c2' => 'required|numeric|min:0',
            'c3' => 'required|numeric|min:0',
            'c4' => 'required|numeric|min:0',
            'c5' => 'required|numeric|min:0',
        ]);

        $existing = DB::table('smart_penilaian')
            ->where('id_alternatif', $request->id_alternatif)
            ->first();

        if ($existing) {
            DB::table('smart_penilaian')->where('id_alternatif', $request->id_alternatif)->update([
                'c1' => $request->c1,
                'c2' => $request->c2,
                'c3' => $request->c3,
                'c4' => $request->c4,
                'c5' => $request->c5,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('smart_penilaian')->insert([
                'id_alternatif' => $request->id_alternatif,
                'c1' => $request->c1,
                'c2' => $request->c2,
                'c3' => $request->c3,
                'c4' => $request->c4,
                'c5' => $request->c5,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('smart.penilaian')->with('success', 'Penilaian berhasil disimpan.');
    }

    public function proses()
    {
        $kriteria = DB::table('smart_kriteria')->get();
        $totalBobot = $kriteria->sum('bobot');

        $kriteria = $kriteria->map(function ($item) use ($totalBobot) {
            $item->normalisasi = $totalBobot > 0
                ? round($item->bobot / $totalBobot, 2)
                : 0;
            return $item;
        });

        $penilaian = DB::table('smart_penilaian')
            ->join('smart_alternatif', 'smart_penilaian.id_alternatif', '=', 'smart_alternatif.id')
            ->select('smart_penilaian.*', 'smart_alternatif.nama_es as nama_es')
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
            $normalisasi[$item->kode_kriteria] = $totalBobot > 0 ? $item->bobot / $totalBobot : 0;
        }

        $penilaian = DB::table('smart_penilaian')
            ->join('smart_alternatif', 'smart_penilaian.id_alternatif', '=', 'smart_alternatif.id')
            ->select('smart_penilaian.*', 'smart_alternatif.nama_es as nama_es')
            ->get();

        $hasil = [];
        foreach ($penilaian as $item) {
            $nilaiAkhir =
                ($item->c1 * ($normalisasi['C1'] ?? 0)) +
                ($item->c2 * ($normalisasi['C2'] ?? 0)) +
                ($item->c3 * ($normalisasi['C3'] ?? 0)) +
                ($item->c4 * ($normalisasi['C4'] ?? 0)) +
                ($item->c5 * ($normalisasi['C5'] ?? 0));

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