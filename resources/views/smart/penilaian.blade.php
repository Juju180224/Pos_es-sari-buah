@extends('layouts.app')
@section('title', 'Penilaian SMART')
@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-sm-6"><h1 class="m-0">Penilaian SMART</h1></div>
    </div>
    <div class="card card-outline card-info">
        <div class="card-header"><h3 class="card-title">Data Penilaian Alternatif</h3></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>Jenis Es</th>
                            <th>C1</th><th>C2</th><th>C3</th><th>C4</th><th>C5</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($alternatif as $item)
                        @php $nilai = $penilaian->firstWhere('id_alternatif', $item->id); @endphp
                        <tr>
                            <td>{{ $item->nama_es }}</td>
                            <td>{{ $nilai->c1 ?? '-' }}</td>
                            <td>{{ $nilai->c2 ?? '-' }}</td>
                            <td>{{ $nilai->c3 ?? '-' }}</td>
                            <td>{{ $nilai->c4 ?? '-' }}</td>
                            <td>{{ $nilai->c5 ?? '-' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalNilai{{ $item->id }}">
                                    {{ $nilai ? 'Edit Nilai' : 'Isi Nilai' }}
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="modalNilai{{ $item->id }}">
                            <div class="modal-dialog"><div class="modal-content">
                                <form action="{{ route('smart.penilaian.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_alternatif" value="{{ $item->id }}">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Nilai - {{ $item->nama_es }}</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group"><label>C1</label><input type="number" step="0.01" name="c1" class="form-control" value="{{ $nilai->c1 ?? '' }}" min="0" required></div>
                                        <div class="form-group"><label>C2</label><input type="number" step="0.01" name="c2" class="form-control" value="{{ $nilai->c2 ?? '' }}" min="0" required></div>
                                        <div class="form-group"><label>C3</label><input type="number" step="0.01" name="c3" class="form-control" value="{{ $nilai->c3 ?? '' }}" min="0" required></div>
                                        <div class="form-group"><label>C4</label><input type="number" step="0.01" name="c4" class="form-control" value="{{ $nilai->c4 ?? '' }}" min="0" required></div>
                                        <div class="form-group"><label>C5</label><input type="number" step="0.01" name="c5" class="form-control" value="{{ $nilai->c5 ?? '' }}" min="0" required></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div></div>
                        </div>
                        @empty
                        <tr><td colspan="7">Belum ada data alternatif. Tambahkan alternatif dulu.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection