@extends('layouts.app')
@section('title', 'Data Kriteria SMART')
@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-sm-6"><h1 class="m-0">Data Kriteria SMART</h1></div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddKriteria">
                <i class="fas fa-plus"></i> Add Data
            </button>
        </div>
    </div>
    <div class="card card-outline card-primary">
        <div class="card-header"><h3 class="card-title">Tabel Data Kriteria</h3></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th width="10%">No</th>
                            <th width="15%">Kode</th>
                            <th>Nama Kriteria</th>
                            <th width="15%">Bobot</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($kriteria as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->kode_kriteria }}</td>
                            <td>{{ $item->nama_kriteria }}</td>
                            <td>{{ $item->bobot }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditKriteria{{ $item->id }}">Edit</button>
                                <form action="{{ route('smart.kriteria.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="modalEditKriteria{{ $item->id }}">
                            <div class="modal-dialog"><div class="modal-content">
                                <form action="{{ route('smart.kriteria.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kriteria</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Kode Kriteria</label>
                                            <input type="text" name="kode_kriteria" class="form-control" value="{{ $item->kode_kriteria }}" maxlength="10" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Kriteria</label>
                                            <input type="text" name="nama_kriteria" class="form-control" value="{{ $item->nama_kriteria }}" maxlength="100" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Bobot</label>
                                            <input type="number" step="0.01" name="bobot" class="form-control" value="{{ $item->bobot }}" min="0" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div></div>
                        </div>
                        @empty
                        <tr><td colspan="5">Belum ada data kriteria</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAddKriteria">
    <div class="modal-dialog"><div class="modal-content">
        <form action="{{ route('smart.kriteria.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Kriteria</label>
                    <input type="text" name="kode_kriteria" class="form-control" placeholder="Contoh: C1" maxlength="10" required>
                </div>
                <div class="form-group">
                    <label>Nama Kriteria</label>
                    <input type="text" name="nama_kriteria" class="form-control" placeholder="Contoh: Rasa" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label>Bobot</label>
                    <input type="number" step="0.01" name="bobot" class="form-control" placeholder="Contoh: 90" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div></div>
</div>
@endsection