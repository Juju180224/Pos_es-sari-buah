@extends('layouts.app')

@section('title', 'Proses SMART')

@section('content')

    <div class="container-fluid">

        <h1 class="mb-4">Proses Perhitungan SMART</h1>

        <!-- Normalisasi -->

        <div class="card card-outline card-primary mb-4">

            <div class="card-header">
                <h3 class="card-title">Normalisasi Bobot</h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead class="text-center">
                        <tr>
                            <th>Kriteria</th>
                            <th>Bobot</th>
                            <th>Normalisasi</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @foreach ($kriteria as $item)
                            <tr>
                                <td>{{ $item->kode_kriteria }}</td>
                                <td>{{ $item->bobot }}</td>
                                <td>{{ $item->normalisasi }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>

        <!-- Utility -->

        <div class="card card-outline card-success">

            <div class="card-header">
                <h3 class="card-title">Nilai Utility</h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead class="text-center">
                        <tr>
                            <th>Jenis Es</th>
                            <th>C1</th>
                            <th>C2</th>
                            <th>C3</th>
                            <th>C4</th>
                            <th>C5</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @forelse ($penilaian as $item)
                            <tr>
                                <td>{{ $item->nama_es }}</td>
                                <td>{{ $item->c1 }}</td>
                                <td>{{ $item->c2 }}</td>
                                <td>{{ $item->c3 }}</td>
                                <td>{{ $item->c4 }}</td>
                                <td>{{ $item->c5 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data penilaian</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

                <div class="mt-4 text-right">
                    <a href="{{ route('smart.hasil') }}" class="btn btn-primary btn-lg">
                        HITUNG SMART
                    </a>
                </div>

            </div>

        </div>

    </div>

@endsection