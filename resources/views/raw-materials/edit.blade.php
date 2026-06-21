@extends('layouts.admin')

@section('title', 'Edit Bahan Baku')
@section('content-header', 'Edit Bahan Baku')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('raw-materials.update', $rawMaterial->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Bahan Baku</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $rawMaterial->name) }}">
            </div>

            <div class="form-group">
                <label>Satuan (kg, liter, gram, pcs, dll)</label>
                <input type="text" name="unit" class="form-control" required value="{{ old('unit', $rawMaterial->unit) }}">
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" step="0.01" name="stock" class="form-control" required value="{{ old('stock', $rawMaterial->stock) }}">
            </div>

            <div class="form-group">
                <label>Harga Beli per Satuan</label>
                <input type="number" step="0.01" name="purchase_price" class="form-control" required value="{{ old('purchase_price', $rawMaterial->purchase_price) }}">
            </div>

            <div class="form-group">
                <label>Batas Stok Menipis</label>
                <input type="number" step="0.01" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', $rawMaterial->low_stock_threshold) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('raw-materials.index') }}" class="btn btn-secondary">Batal</a>

        </form>

    </div>
</div>

@endsection
