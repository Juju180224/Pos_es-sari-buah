@extends('layouts.app')

@section('title', 'Data Alternatif SMART')

@section('content')

    <div class="container-fluid">

        <div class="row mb-3">

            <div class="col-sm-6">
                <h1 class="m-0">Data Alternatif SMART</h1>
            </div>

            <div class="col-sm-6 text-right">
                <button class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Data
                </button>
            </div>

        </div>

        <div class="card card-outline card-success">

            <div class="card-header">
                <h3 class="card-title">Tabel Data Alternatif</h3>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead class="text-center">

                            <tr>
                                <th width="10%">No</th>
                                <th width="20%">Kode</th>
                                <th>Nama Jenis Es</th>
                                <th width="20%">Action</th>
                            </tr>

                        </thead>

                        <tbody class="text-center">

                            <tr>
                                <td>1</td>
                                <td>A1</td>
                                <td>Es Alpukat</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>A2</td>
                                <td>Es Mangga</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>A3</td>
                                <td>Es Sirsak</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>A4</td>
                                <td>Es Cappucino</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>

                            <tr>
                                <td>5</td>
                                <td>A5</td>
                                <td>Es Jambu</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td>A6</td>
                                <td>Es Kelapa</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
