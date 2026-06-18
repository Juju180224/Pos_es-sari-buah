@extends('layouts.app')

@section('content')
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        #app,
        main {
            margin: 0 !important;
            padding: 0 !important;
        }

        main {
            margin-top: 70px !important;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #0d0b09;
            z-index: 999;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 40px;
        }

        .nav-menu ul {
            display: flex;
            list-style: none;
            gap: 30px;
            margin: 0;
            padding: 0;
        }

        .nav-menu ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 0.5px;
            transition: color 0.3s ease;
        }

        .nav-menu ul li a:hover,
        .nav-menu ul li a.active {
            color: #f2be2f;
        }

        .nav-icon {
            display: flex;
            gap: 18px;
        }

        .nav-icon a {
            color: #f2be2f;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .nav-icon a:hover {
            transform: scale(1.1);
            color: #ffd87d;
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            background: linear-gradient(135deg, #f2be2f 0%, #f4d560 40%, #fce8a8 100%);
            padding: 100px 0 120px;
            position: relative;
            overflow: hidden;
        }

        .hero-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4rem;
        }

        .hero-content {
            flex: 1;
            max-width: 550px;
            z-index: 2;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #4f3b26;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .hero-tag::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #231f20;
            border-radius: 50%;
        }

        .hero-title {
            font-size: 3.8rem;
            font-weight: 900;
            line-height: 1.1;
            color: #231f20;
            margin-bottom: 1.5rem;
            word-spacing: 9999px;
        }

        .hero-title span {
            word-spacing: normal;
        }

        .hero-description {
            font-size: 1.05rem;
            color: #5a4a3a;
            line-height: 1.8;
            margin-bottom: 2.5rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1.2rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: #231f20;
            color: #fff;
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #231f20;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-hero-primary:hover {
            background: #3a3738;
            border-color: #3a3738;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(35, 31, 32, 0.25);
        }

        .btn-hero-secondary {
            border: 2px solid #231f20;
            color: #231f20;
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-hero-secondary:hover {
            background: #231f20;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(35, 31, 32, 0.15);
        }

        /* ===== HERO IMAGE CARD ===== */
        .hero-image-card {
            flex: 1;
            max-width: 680px;
            min-width: 420px;
            background: linear-gradient(180deg, #1f1b19 0%, #16120f 100%);
            border-radius: 28px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
        }

        .image-container {
            width: 100%;
            height: 420px;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 2px 12px rgba(0, 0, 0, 0.35);
            background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.08), transparent 35%);
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.5s ease;
        }

        .image-container:hover .hero-image {
            transform: scale(1.05);
        }

        .card-label {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            color: #ffd87d;
            padding: 0.6rem 1.2rem;
            border-radius: 999px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* ===== SERVICE CARDS ===== */
        .service-card {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-align: center;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }

        .service-number {
            display: inline-flex;
            width: 70px;
            height: 70px;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f2be2f, #f4d560);
            border-radius: 18px;
            font-size: 1.8rem;
            font-weight: 800;
            color: #231f20;
            margin-bottom: 1.5rem;
        }

        .service-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #231f20;
            margin-bottom: 1rem;
        }

        .service-card p {
            color: #6a5a49;
            line-height: 1.7;
            font-size: 0.95rem;
        }

        /* ===== SIDEBAR / CONTENT ===== */
        .content-sidebar-section {
            padding: 80px 0;
            background: #fff8ed;
        }

        .sidebar-layout {
            display: flex;
            gap: 2.5rem;
            align-items: flex-start;
        }

        .sidebar-main {
            flex: 2;
        }

        .sidebar-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .sidebar-card {
            background: #fff;
            border-radius: 24px;
            padding: 1.8rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .sidebar-card:hover {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }

        .sidebar-label {
            display: inline-block;
            background: #f2be2f;
            color: #231f20;
            border-radius: 999px;
            padding: 0.45rem 1rem;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 1rem;
        }

        .sidebar-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #231f20;
            margin-bottom: 0.8rem;
        }

        .sidebar-card p,
        .sidebar-card li {
            color: #5a4a3a;
            line-height: 1.8;
            font-size: 0.95rem;
        }

        .opening-hours {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .opening-hours li {
            margin-bottom: 0.9rem;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .opening-hours span:first-child {
            color: #231f20;
            font-weight: 600;
        }

        .special-offer {
            background: #231f20;
            color: #fff;
        }

        .special-offer .sidebar-label {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .special-offer p {
            color: rgba(255, 255, 255, 0.75);
        }

        .special-offer strong {
            color: #f2be2f;
        }

        /* ===== SERVICES SECTION ===== */
        .services-section {
            padding: 80px 0;
            background: #fff;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 800;
            color: #231f20;
            margin-bottom: 3rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .service-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        /* ===== MENU SECTION ===== */
        .menu-section {
            background: #231f20;
            padding: 80px 0;
            color: #fff;
        }

        .menu-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        .menu-category h4 {
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #f2be2f;
            margin-bottom: 2rem;
            font-weight: 700;
        }

        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .menu-item:last-child {
            border: none;
        }

        .menu-item-name {
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.3rem;
        }

        .menu-item-desc {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .menu-item-price {
            color: #f2be2f;
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* ===== CTA SECTION ===== */
        .cta-section {
            background: #1a1614;
            color: #fff;
            padding: 60px;
            border-radius: 25px;
            text-align: center;
            margin: 80px 0;
        }

        .cta-section h2 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: #fff;
        }

        .cta-section p {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1.2rem;
            flex-wrap: wrap;
        }

        .cta-btn-primary {
            background: #f2be2f;
            color: #231f20;
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .cta-btn-primary:hover {
            background: #ffd87d;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(242, 190, 47, 0.3);
        }

        .cta-btn-secondary {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .cta-btn-secondary:hover {
            background: #fff;
            color: #231f20;
            transform: translateY(-2px);
        }

        .page-section {
            padding: 80px 0;
            background: #fff;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: #231f20;
        }

        .page-text {
            font-size: 1rem;
            color: #5a4a3a;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        /* ===== PRODUCT GRID BARU ===== */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            align-items: stretch;
            margin-top: 30px;
        }

        .product-card {
            background: #fff8ed;
            padding: 15px;
            border-radius: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .product-card h3 {
            margin-top: 10px;
            font-size: 18px;
            color: #231f20;
        }

        .product-card p {
            font-size: 14px;
            color: #555;
        }

        .contact-box {
            background: #fff8ed;
            padding: 20px;
            border-radius: 15px;
            margin-top: 30px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        /* ===== FOOTER ===== */
        footer {
            background: #0d0b09;
            color: #fff;
            padding: 2.5rem 0;
            text-align: center;
            font-size: 0.9rem;
        }

        footer p {
            margin: 0.5rem 0;
            color: rgba(255, 255, 255, 0.7);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .hero-wrapper {
                gap: 2.5rem;
            }

            .image-container {
                height: 350px;
            }
        }

        @media (max-width: 991px) {
            .sidebar-layout {
                flex-direction: column;
            }

            .hero-wrapper {
                flex-direction: column;
                gap: 3rem;
            }

            .hero-image-card {
                max-width: 100%;
                min-width: auto;
            }

            .image-container {
                height: 320px;
            }

            .menu-wrapper {
                grid-template-columns: 1fr;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-wrapper {
                padding: 10px 20px;
            }

            .nav-menu ul {
                gap: 20px;
                font-size: 13px;
            }

            .hero-section {
                padding: 60px 0 80px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .image-container {
                height: 280px;
            }

            .cta-section {
                margin: 40px 0;
                padding: 40px 20px;
            }

            .cta-section h2 {
                font-size: 1.8rem;
            }

            .service-cards {
                gap: 1.5rem;
            }
        }

        @media (max-width: 600px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="container nav-wrapper">
            <div class="logo">
                <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" height="45" alt="logo"></a>
            </div>
            <nav class="nav-menu">
                <ul>
                    <li><a href="{{ route('home') }}" class="active">Home</a></li>
                    <li><a href="{{ route('menu') }}">Menu</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
            <div class="nav-icon">
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-wrapper">
                <div class="hero-content">
                    <span class="hero-tag">POS Es Sari Buah</span>

                    <h1 class="hero-title">
                        FRESH & SWEET <span>FRUIT DRINKS</span>
                    </h1>

                    <p class="hero-description">
                        Kelola penjualan Es Sari Buah dengan sistem POS modern yang cepat, rapi, dan mudah digunakan. Cocok
                        untuk
                        usaha minuman segar, jus buah, dan kedai minuman kekinian.
                    </p>

                    <div class="hero-buttons">
                        <a href="{{ route('menu') }}" class="btn-hero-primary">Order Now</a>

                        @guest
                            <a href="{{ route('login') }}" class="btn-hero-secondary">Login</a>
                        @else
                            <a href="{{ route('home') }}" class="btn-hero-secondary">Dashboard</a>
                        @endguest
                    </div>
                </div>

                <div class="hero-image-card">
                    <span class="card-label">Featured Product</span>
                    <div class="image-container">
                        <img src="/images/banners/hero-es-sari.jpg" alt="Es Sari Buah" class="hero-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SIDEBAR + CONTENT -->
    <section class="content-sidebar-section">
        <div class="container">
            <div class="sidebar-layout">
                <div class="sidebar-main">
                    <div class="section-title" style="text-align:left">Kenapa Es Sari Buah?</div>
                    <p style="max-width:660px;color:#5a4a3a;margin-bottom:2rem">
                        Dapatkan pengalaman pengelolaan kedai yang lebih efisien dengan tampilan modern, pemesanan cepat,
                        dan laporan penjualan yang mudah dibaca.
                    </p>

                    <div class="service-cards">
                        <div class="service-card">
                            <div class="service-number">01</div>
                            <h3>Operasi Cepat</h3>
                            <p>Fitur POS dibuat untuk proses pesanan yang lancar dan responsif di setiap meja.</p>
                        </div>

                        <div class="service-card">
                            <div class="service-number">02</div>
                            <h3>Stok Terpantau</h3>
                            <p>Pantau ketersediaan bahan & minuman langsung dari dashboard tanpa ribet.</p>
                        </div>

                        <div class="service-card">
                            <div class="service-number">03</div>
                            <h3>Promo & Penawaran</h3>
                            <p>Atur promo dengan mudah dan dorong order repeat melalui penawaran khusus.</p>
                        </div>
                    </div>
                </div>

                <aside class="sidebar-panel">
                    <div class="sidebar-card">
                        <span class="sidebar-label">Opening Hours</span>
                        <ul class="opening-hours">
                            <li><span>Senin - Jumat</span><span>09:00 - 17:00</span></li>
                            <li><span>Sabtu</span><span>10:00 - 17:00</span></li>
                            <li><span>Minggu</span><span>10:00 - 17:00</span></li>
                        </ul>
                    </div>

                    <div class="sidebar-card">
                        <span class="sidebar-label">Contact</span>
                        <p>
                            Hubungi kami untuk pemesanan besar atau dukungan operasional.<br>
                            <strong>Tlp:</strong> +62 896 3005 6990<br>
                            <strong>Email:</strong> essaribuah@gmail.com
                        </p>
                    </div>

                    <div class="sidebar-card">
                        <span class="sidebar-label">Promo Hari Ini</span>
                        <h3>Es Sari Buah Segar</h3>
                        <p>Beli 2 Gratis 1 untuk semua varian minuman segar.</p>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- PRODUK -->
    <section class="page-section">
        <div class="container">
            <h2 class="page-title">Produk Pilihan</h2>

            <p class="page-text">
                Temukan minuman segar favorit dari Es Sari Buah yang dibuat dari bahan alami dan disajikan dengan tampilan
                menarik.
            </p>

            <div class="product-grid">
                <div class="product-card">
                    <img src="{{ asset('images/alpukat.jpg') }}" alt="Es Alpukat">
                    <h3>Es Alpukat</h3>
                    <p>Campuran alpukat segar, susu, dan gula murni.</p>
                </div>

                <div class="product-card">
                    <img src="{{ asset('images/mangga.jpg') }}" alt="Es Mangga">
                    <h3>Es Mangga</h3>
                    <p>Perpaduan mangga manis dan es serut segar.</p>
                </div>

                <div class="product-card">
                    <img src="{{ asset('images/jambu.jpg') }}" alt="Es Jambu">
                    <h3>Es Jambu</h3>
                    <p>Jambu merah asli dengan rasa segar dan alami.</p>
                </div>
            </div>

            <div class="contact-box">
                <h3>Hubungi Kami</h3>
                <p>Pesan sekarang atau tanyakan promo hari ini dengan menghubungi nomor berikut.</p>
                <p><strong>Tel:</strong> +62 896 3005 6990</p>
                <p><strong>Email:</strong> essaribuah@gmail.com</p>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section class="services-section">
        <div class="container">
            <h2 class="section-title">OUR SERVICES</h2>

            <div class="service-cards">
                <div class="service-card">
                    <div class="service-number">01</div>
                    <h3>Fresh & Natural</h3>
                    <p>Es Sari Buah dibuat dari buah segar pilihan untuk menjaga rasa tetap manis, segar, dan konsisten.</p>
                </div>

                <div class="service-card">
                    <div class="service-number">02</div>
                    <h3>Fast Ordering</h3>
                    <p>Sistem pemesanan cepat dan mudah, cocok untuk pembelian langsung maupun take away.</p>
                </div>

                <div class="service-card">
                    <div class="service-number">03</div>
                    <h3>Custom Menu</h3>
                    <p>Pelanggan dapat memilih variasi buah dan rasa sesuai selera dengan fleksibilitas penuh.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- MENU SECTION -->
    <section class="menu-section">
        <div class="container">
            <h2 class="section-title" style="color:#f2be2f;margin-bottom:3rem">MENU</h2>

            <div class="menu-wrapper">
                <div class="menu-category">
                    <h4>Es Sari Buah</h4>

                    <div class="menu-item">
                        <div>
                            <div class="menu-item-name">1/ Alpukat</div>
                            <div class="menu-item-desc">Es Alpukat asli dengan susu dan es batu segar</div>
                        </div>
                        <div class="menu-item-price">Rp 7.000</div>
                    </div>

                    <div class="menu-item">
                        <div>
                            <div class="menu-item-name">2/ Mangga</div>
                            <div class="menu-item-desc">Es Mangga manis dengan sirup dan es dingin</div>
                        </div>
                        <div class="menu-item-price">Rp 7.000</div>
                    </div>

                    <div class="menu-item">
                        <div>
                            <div class="menu-item-name">3/ Es Jambu</div>
                            <div class="menu-item-desc">Jambu merah segar dengan rasa manis alami</div>
                        </div>
                        <div class="menu-item-price">Rp 7.000</div>
                    </div>
                </div>

                <div class="menu-category">
                    <h4>Minuman Segar</h4>

                    <div class="menu-item">
                        <div>
                            <div class="menu-item-name">4/ Es Kelapa</div>
                            <div class="menu-item-desc">Air kelapa asli dengan daging kelapa segar</div>
                        </div>
                        <div class="menu-item-price">Rp 7.000</div>
                    </div>

                    <div class="menu-item">
                        <div>
                            <div class="menu-item-name">5/ Es Cappucino</div>
                            <div class="menu-item-desc">Cappucino segar dengan es dan susu kental manis</div>
                        </div>
                        <div class="menu-item-price">Rp 7.000</div>
                    </div>

                    <div class="menu-item">
                        <div>
                            <div class="menu-item-name">6/ Es Sirsak</div>
                            <div class="menu-item-desc">Sirsak segar dengan campuran susu creamy</div>
                        </div>
                        <div class="menu-item-price">Rp 7.000</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <div class="container">
        <div class="cta-section">
            <h2>Mulai Usaha Es Sari Buah Sekarang</h2>

            <p>
                Bangun sistem penjualan minuman segar yang cepat, modern, dan mudah digunakan. Cocok untuk usaha es buah,
                jus, dan minuman kekinian agar penjualan lebih teratur dan menguntungkan.
            </p>

            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="cta-btn-primary">Daftar Gratis</a>
                <a href="{{ route('menu') }}" class="cta-btn-secondary">Cek Menu</a>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>© 2026 {{ config('settings.app_name', 'Es Sari Buah') }}</p>
            <p>POS System untuk Es Sari Buah & Minuman Segar</p>
        </div>
    </footer>
@endsection
