@extends('layouts.app')

@section('title', 'Data Kriteria SMART')

@section('content')

    <div class="container-fluid">

        <!-- Header -->
        <div class="row mb-3">

            <div class="col-sm-6">
                <h1 class="m-0">Data Kriteria SMART</h1>
            </div>

            <div class="col-sm-6 text-right">
                <button class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Data
                </button>
            </div>

        </div>

        <!-- Card -->
        <div class="card card-outline card-primary">

            <div class="card-header">
                <h3 class="card-title">
                    Tabel Data Kriteria
                </h3>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead class="text-center">

                            <tr>
                                <th width="10%">No</th>
                                <th width="15%">Kode</th>
                                <th>Nama Kriteria</th>
                                <th width="15%">Bobot</th>
                                <th width="15%">Jenis</th>
                                <th width="20%">Action</th>
                            </tr>

                        </thead>

                        <tbody class="text-center">

                            <tr>
                                <td>1</td>
                                <td>C1</td>
                                <td>Rasa</td>
                                <td>90</td>
                                <td>
                                    <span class="badge badge-success">
                                        Benefit
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit
                                    </button>

                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>C2</td>
                                <td>Tingkat Penjualan</td>
                                <td>88</td>
                                <td>
                                    <span class="badge badge-success">
                                        Benefit
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit
                                    </button>

                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>C3</td>
                                <td>Minat Pelanggan</td>
                                <td>85</td>
                                <td>
                                    <span class="badge badge-success">
                                        Benefit
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit
                                    </button>

                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>C4</td>
                                <td>Harga</td>
                                <td>80</td>
                                <td>
                                    <span class="badge badge-success">
                                        Benefit
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit
                                    </button>

                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>5</td>
                                <td>C5</td>
                                <td>Kualitas Bahan</td>
                                <td>87</td>
                                <td>
                                    <span class="badge badge-success">
                                        Benefit
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit
                                    </button>

                                    <button class="btn btn-danger btn-sm">
                                        Delete
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
