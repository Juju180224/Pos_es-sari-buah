@extends('layouts.admin')

@section('title', 'Tambah Bahan Baku')
@section('content-header', 'Tambah Bahan Baku')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('raw-materials.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Bahan Baku</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label>Satuan (kg, liter, gram, pcs, dll)</label>
                <input type="text" name="unit" class="form-control" required value="{{ old('unit') }}">
            </div>

            <div class="form-group">
                <label>Stok Awal</label>
                <input type="number" step="0.01" name="stock" class="form-control" required value="{{ old('stock', 0) }}">
            </div>

            <div class="form-group">
                <label>Harga Beli per Satuan</label>
                <input type="number" step="0.01" name="purchase_price" class="form-control" required value="{{ old('purchase_price', 0) }}">
            </div>

            <div class="form-group">
                <label>Batas Stok Menipis</label>
                <input type="number" step="0.01" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', 5) }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('raw-materials.index') }}" class="btn btn-secondary">Batal</a>

        </form>

    </div>
</div>

@endsection
