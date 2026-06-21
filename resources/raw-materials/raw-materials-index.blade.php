@extends('layouts.admin')

@section('title', 'Bahan Baku & Perlengkapan')
@section('content-header', 'Bahan Baku & Perlengkapan')

@section('content-actions')
    <a href="{{ route('raw-materials.create') }}" class="btn btn-primary">
        + Tambah Bahan Baku
    </a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('raw-materials.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari bahan baku..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rawMaterials as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ number_format($item->stock, 2) }}</td>
                        <td>{{ config('settings.currency_symbol') }} {{ number_format($item->purchase_price, 2) }}</td>
                        <td>
                            @if($item->isLowStock())
                                <span class="badge badge-danger">Stok Menipis</span>
                            @else
                                <span class="badge badge-success">Aman</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('raw-materials.edit', $item->id) }}" class="btn btn-sm btn-secondary">
                                Edit
                            </a>
                            <form action="{{ route('raw-materials.destroy', $item->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus bahan baku ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $rawMaterials->links() }}

    </div>
</div>

@endsection
