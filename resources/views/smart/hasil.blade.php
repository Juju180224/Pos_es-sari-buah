`@extends('layouts.app')

@section('title', 'Hasil Ranking SMART')

@section('content')

    <div class="container-fluid">

        <h1 class="mb-4">Hasil Ranking SMART</h1>

        <!-- CARD INFO -->

        <div class="row">

            <div class="col-md-4">

                <div class="small-box bg-success">

                    <div class="inner">
                        <h3>Es Alpukat</h3>
                        <p>Jenis Es Terbaik</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-trophy"></i>
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="small-box bg-info">

                    <div class="inner">
                        <h3>90</h3>
                        <p>Nilai Tertinggi</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="small-box bg-warning">

                    <div class="inner">
                        <h3>6</h3>
                        <p>Total Alternatif</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>

                </div>

            </div>

        </div>

        <!-- TABEL -->

        <div class="card card-outline card-primary">

            <div class="card-header">
                <h3 class="card-title">Tabel Hasil Ranking</h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped">

                    <thead class="text-center">

                        <tr>
                            <th>Ranking</th>
                            <th>Jenis Es</th>
                            <th>Nilai Akhir</th>
                        </tr>

                    </thead>

                    <tbody class="text-center">

                        <tr>
                            <td>1</td>
                            <td>Es Alpukat</td>
                            <td>90</td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Es Mangga</td>
                            <td>80.5</td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Es Sirsak</td>
                            <td>60.4</td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>Es Cappucino</td>
                            <td>50</td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>Es Jambu</td>
                            <td>40.2</td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>Es Kelapa</td>
                            <td>10</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
