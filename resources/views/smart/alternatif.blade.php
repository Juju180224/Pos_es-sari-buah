@extends('layouts.app')
@section('title', 'Data Alternatif SMART')
@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-sm-6"><h1 class="m-0">Data Alternatif SMART</h1></div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddAlternatif">
                <i class="fas fa-plus"></i> Add Data
            </button>
        </div>
    </div>
    <div class="card card-outline card-success">
        <div class="card-header"><h3 class="card-title">Tabel Data Alternatif</h3></div>
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
                        @forelse($alternatif as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->kode_alternatif ?? '-' }}</td>
                            <td>{{ $item->nama_es }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditAlternatif{{ $item->id }}">Edit</button>
                                <form action="{{ route('smart.alternatif.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="modalEditAlternatif{{ $item->id }}">
                            <div class="modal-dialog"><div class="modal-content">
                                <form action="{{ route('smart.alternatif.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Alternatif</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Kode Alternatif</label>
                                            <input type="text" name="kode_alternatif" class="form-control" value="{{ $item->kode_alternatif }}" maxlength="10">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Jenis Es</label>
                                            <input type="text" name="nama_es" class="form-control" value="{{ $item->nama_es }}" maxlength="100" required>
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
                        <tr><td colspan="4">Belum ada data alternatif</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAddAlternatif">
    <div class="modal-dialog"><div class="modal-content">
        <form action="{{ route('smart.alternatif.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Alternatif</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Alternatif</label>
                    <input type="text" name="kode_alternatif" class="form-control" placeholder="Contoh: A1" maxlength="10">
                </div>
                <div class="form-group">
                    <label>Nama Jenis Es</label>
                    <input type="text" name="nama_es" class="form-control" placeholder="Contoh: Es Alpukat" maxlength="100" required>
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