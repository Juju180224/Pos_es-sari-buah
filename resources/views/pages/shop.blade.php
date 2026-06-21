@extends('layouts.app')

@section('content')

<section class="page-section">
    <div class="container">

        <h1 class="page-title">Menu Produk</h1>

        <p class="page-text">
            Berikut adalah daftar minuman Es Sari Buah yang tersedia.
        </p>

        <div class="product-grid">

            <div class="product-card">
                <img src="/images/alpukat.jpg" alt="Alpukat">
                <h3>Es Alpukat</h3>
                <p>Rp 7.000</p>
            </div>

            <div class="product-card">
                <img src="/images/mangga.jpg" alt="Mangga">
                <h3>Es Mangga</h3>
                <p>Rp 7.000</p>
            </div>

            <div class="product-card">
                <img src="/images/jambu.jpg" alt="Jambu">
                <h3>Es Jambu</h3>
                <p>Rp 7.000</p>
            </div>

            <div class="product-card">
                <img src="/images/kelapa.jpg" alt="Kelapa">
                <h3>Es Kelapa</h3>
                <p>Rp 7.000</p>
            </div>

        </div>

    </div>
</section>

@endsection