@extends('layouts.app')

@section('title', 'Penilaian SMART')

@section('content')

    <div class="container-fluid">

        <div class="row mb-3">

            <div class="col-sm-6">
                <h1 class="m-0">Penilaian SMART</h1>
            </div>

            <div class="col-sm-6 text-right">
                <button class="btn btn-success">
                    Simpan Penilaian
                </button>
            </div>

        </div>

        <div class="card card-outline card-info">

            <div class="card-header">
                <h3 class="card-title">Data Penilaian Alternatif</h3>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead class="text-center">

                            <tr>
                                <th>Jenis Es</th>
                                <th>C1</th>
                                <th>C2</th>
                                <th>C3</th>
                                <th>C4</th>
                                <th>C5</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody class="text-center">

                            <tr>
                                <td>Es Alpukat</td>
                                <td>3</td>
                                <td>3</td>
                                <td>3</td>
                                <td>2</td>
                                <td>3</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit Nilai
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>Es Mangga</td>
                                <td>3</td>
                                <td>3</td>
                                <td>2</td>
                                <td>2</td>
                                <td>3</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit Nilai
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>Es Sirsak</td>
                                <td>3</td>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit Nilai
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>Es Cappucino</td>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit Nilai
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>Es Jambu</td>
                                <td>2</td>
                                <td>1</td>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit Nilai
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>Es Kelapa</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>2</td>
                                <td>1</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit Nilai
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
