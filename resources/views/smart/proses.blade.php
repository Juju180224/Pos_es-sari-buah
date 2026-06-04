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

                        <tr>
                            <td>C1</td>
                            <td>90</td>
                            <td>0.21</td>
                        </tr>

                        <tr>
                            <td>C2</td>
                            <td>88</td>
                            <td>0.20</td>
                        </tr>

                        <tr>
                            <td>C3</td>
                            <td>85</td>
                            <td>0.20</td>
                        </tr>

                        <tr>
                            <td>C4</td>
                            <td>80</td>
                            <td>0.18</td>
                        </tr>

                        <tr>
                            <td>C5</td>
                            <td>87</td>
                            <td>0.20</td>
                        </tr>

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

                        <tr>
                            <td>Es Alpukat</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>50</td>
                            <td>100</td>
                        </tr>

                    </tbody>

                </table>

                <div class="mt-4 text-right">

                    <button class="btn btn-primary btn-lg">
                        HITUNG SMART
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
