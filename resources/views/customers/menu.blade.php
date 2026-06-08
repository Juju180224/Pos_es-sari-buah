<!DOCTYPE html>
<html lang="id">

<head>
    <title>Menu Minuman</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png?v=2') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png?v=2') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png?v=2') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #111214;
            --surface: #1a1c20;
            --surface2: #22252b;
            --border: #2e3138;
            --accent: #27ae60;
            --accent-hover: #2ecc71;
            --text: #e8eaf0;
            --muted: #7a7f8e;
            --price: #27ae60;
            --card-radius: 14px;
            --font-display: 'Playfair Display', serif;
            --font-body: 'DM Sans', sans-serif;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* HEADER */
        .header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 24px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-display);
            font-size: 17px;
            color: var(--text);
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--border);
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-icon-btn {
            position: relative;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: var(--accent);
            color: white;
            font-size: 10px;
            font-weight: 700;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .cart-popup {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: min(340px, calc(100vw - 32px));
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            padding: 16px;
            display: none;
            z-index: 400;
        }

        .cart-popup.visible {
            display: block;
        }

        .cart-popup-header {
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--text);
        }

        .cart-popup-items {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 320px;
            overflow-y: auto;
        }

        .popup-cart-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            padding: 12px;
            border-radius: 12px;
            background: var(--surface2);
            border: 1px solid var(--border);
        }

        .popup-cart-item .cart-item-name {
            margin-bottom: 6px;
        }

        .popup-cart-empty {
            color: var(--muted);
            font-size: 14px;
            text-align: center;
            padding: 20px 0;
        }

        /* HERO */
        .hero {
            text-align: center;
            padding: 40px 20px 20px;
            background: linear-gradient(135deg, var(--surface) 0%, var(--surface2) 100%);
        }

        .hero h1 {
            font-family: var(--font-display);
            font-size: 42px;
            margin-bottom: 8px;
        }

        .hero p {
            color: var(--muted);
            font-size: 16px;
        }

        /* SEARCH */
        .search-wrap {
            display: flex;
            justify-content: center;
            padding: 24px 20px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .search-bar {
            width: 100%;
            max-width: 600px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 14px;
            display: flex;
            align-items: center;
            padding: 12px 18px;
            gap: 10px;
        }

        .search-bar input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text);
            width: 100%;
            font-size: 15px;
        }

        /* CATEGORY */
        .category-wrap {
            display: flex;
            justify-content: center;
            gap: 12px;
            padding: 20px;
            flex-wrap: wrap;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .cat-btn {
            padding: 10px 24px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--surface2);
            color: var(--muted);
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 14px;
        }

        .cat-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .cat-btn.active {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        /* GRID */
        .container {
            padding: 40px 20px 120px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }

        @media(min-width: 1200px) {
            .grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        @media(min-width: 992px) and (max-width: 1199px) {
            .grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media(min-width: 768px) and (max-width: 991px) {
            .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width: 767px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* CARD */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--card-radius);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: var(--accent);
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(39, 174, 96, 0.15);
        }

        .card-img-wrap {
            position: relative;
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: #1a1c20;
        }

        .card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .card-body {
            padding: 14px;
            flex: 1;
        }

        .card-name {
            font-weight: 600;
            font-size: 15px;
            line-height: 1.3;
        }

        .card-code {
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
        }

        .card-footer {
            padding: 12px 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            border-top: 1px solid var(--border);
        }

        .card-price {
            font-size: 16px;
            font-weight: bold;
            color: var(--accent);
            white-space: nowrap;
        }

        .add-btn {
            background: var(--accent);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
            flex-shrink: 0;
        }

        .add-btn:hover {
            background: var(--accent-hover);
        }

        .qty-box {
            display: none;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .qty-box.visible {
            display: flex;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border);
            background: var(--surface2);
            color: var(--text);
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s;
        }

        .qty-btn:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .qty-input {
            width: 40px;
            text-align: center;
            background: transparent;
            border: none;
            color: white;
            font-weight: bold;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--border);
        }

        .cart-item-name {
            font-size: 14px;
            font-weight: 600;
        }

        .cart-item-qty {
            font-size: 12px;
            color: var(--muted);
        }

        .cart-item-price {
            color: var(--accent);
            font-weight: bold;
        }

        /* CART BAR */
        .cart-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--accent);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            transform: translateY(100%);
            transition: .3s;
        }

        .cart-bar.visible {
            transform: translateY(0);
        }

        .order-btn {
            background: white;
            color: var(--accent);
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">

        <div class="header-logo">
            <div class="logo-icon">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </div>

            Es Sari Buah
        </div>

        <button class="cart-icon-btn" onclick="toggleCartPopup()">
            🛒
            <span class="cart-badge" id="cartBadge">0</span>
        </button>

        <!-- POPUP CART -->
        <div class="cart-popup" id="cartPopup">

            <div class="cart-popup-header">
                Keranjang Saya
            </div>

            <div id="popupCartItems" class="cart-popup-items"></div>

        </div>

    </div>

    <!-- HERO -->
    <div class="hero">
        <h1>Menu Minuman</h1>
        <p>Pilih minuman favoritmu</p>
    </div>

    <!-- SEARCH -->
    <div class="search-wrap">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Cari produk..." oninput="filterProducts()">
        </div>
    </div>

    <!-- CATEGORY -->
    <div class="category-wrap">

        <button class="cat-btn active" onclick="filterCategory('all', this)">
            Semua
        </button>

        @foreach ($categories ?? [] as $cat)
            <button class="cat-btn" onclick="filterCategory('{{ $cat->slug }}', this)">
                {{ $cat->name }}
            </button>
        @endforeach

    </div>

    <!-- FORM -->
    <form action="{{ route('menu.checkout') }}" method="POST">

        @csrf

        <div class="container">

            <div class="grid">

                @foreach ($products as $product)
                    <div class="card" data-name="{{ strtolower($product->name) }}"
                        data-category="{{ $product->category->slug ?? 'all' }}">

                        <!-- IMAGE -->
                        @php
                            $imagePath = $product->image
                                ? asset('storage/' . ltrim($product->image, '/'))
                                : asset('images/no-image.png');
                        @endphp

                        <div class="card-img-wrap">

                            <img src="{{ $imagePath }}" alt="{{ $product->name }}" loading="lazy"
                                onerror="this.src='{{ asset('images/no-image.png') }}'">

                        </div>
                        <!-- BODY -->
                        <div class="card-body">

                            <div class="card-name">
                                {{ $product->name }}
                            </div>

                            <div class="card-code">
                                Kode:
                                {{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}
                            </div>

                        </div>

                        <!-- FOOTER -->
                        <div class="card-footer">

                            <div class="card-price" id="price{{ $product->id }}" data-price="{{ $product->price }}">

                                Rp
                                {{ number_format($product->price, 0, ',', '.') }}

                            </div>

                            <!-- ADD BUTTON -->
                            <button type="button" class="add-btn" id="addBtn{{ $product->id }}"
                                onclick="addToCart({{ $product->id }})">

                                Tambah

                            </button>

                            <!-- QTY -->
                            <div class="qty-box" id="qtyBox{{ $product->id }}">

                                <!-- MINUS -->
                                <button type="button" class="qty-btn minus-btn" onclick="minus({{ $product->id }})">

                                    −

                                </button>

                                <!-- QTY -->
                                <input type="number" class="qty-input" name="qty[{{ $product->id }}]"
                                    id="qty{{ $product->id }}" value="1" min="1" readonly>

                                <!-- PLUS -->
                                <button type="button" class="qty-btn plus-btn" onclick="plus({{ $product->id }})">

                                    +

                                </button>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

        <!-- CART BAR -->
        <div class="cart-bar" id="cartBar">

            <div>
                <div>
                    <span id="totalItem">0</span> item dipilih
                </div>

                <div>
                    Rp <span id="totalPrice">0</span>
                </div>
            </div>

            <button type="submit" class="order-btn">
                Pesan Sekarang →
            </button>

        </div>

    </form>

    <script>
        // TAMBAH
        function plus(id) {

            let input = document.getElementById('qty' + id);

            input.value = parseInt(input.value) + 1;

            updateCart();
        }

        // KURANG
        function minus(id) {

            let input = document.getElementById('qty' + id);

            if (parseInt(input.value) > 0) {

                input.value = parseInt(input.value) - 1;

                if (parseInt(input.value) === 0) {

                    document.getElementById('qtyBox' + id)
                        .classList.remove('visible');

                    document.getElementById('addBtn' + id)
                        .style.display = 'block';
                }

                updateCart();
            }
        }

        // ADD TO CART
        function addToCart(id) {

            document.getElementById('addBtn' + id)
                .style.display = 'none';

            document.getElementById('qtyBox' + id)
                .classList.add('visible');

            document.getElementById('qty' + id)
                .value = 1;

            updateCart();
        }

        // UPDATE CART
        function updateCart() {

            let totalItem = 0;
            let totalPrice = 0;

            let cartHTML = '';

            @foreach ($products as $product)

                let el{{ $product->id }} =
                    document.getElementById('qty{{ $product->id }}');

                if (el{{ $product->id }}) {

                    let q =
                        parseInt(el{{ $product->id }}.value) || 0;

                    let p =
                        parseInt(document.getElementById(
                            'price{{ $product->id }}'
                        ).dataset.price) || 0;

                    totalItem += q;

                    totalPrice += q * p;

                    if (q > 0) {

                        cartHTML += `
                            <div class="cart-item">

                                <div>

                                    <div class="cart-item-name">
                                        {{ $product->name }}
                                    </div>

                                    <div class="cart-item-qty">
                                        Qty: ${q}
                                    </div>

                                </div>

                                <div class="cart-item-price">
                                    Rp ${(q * p).toLocaleString('id-ID')}
                                </div>

                            </div>
                        `;
                    }
                }
            @endforeach

            document.getElementById('totalItem')
                .innerText = totalItem;

            document.getElementById('totalPrice')
                .innerText =
                totalPrice.toLocaleString('id-ID');

            let popupCartItems =
                document.getElementById('popupCartItems');

            popupCartItems.innerHTML = cartHTML;

            let bar =
                document.getElementById('cartBar');

            let badge =
                document.getElementById('cartBadge');

            if (totalItem > 0) {

                bar.classList.add('visible');

                badge.style.display = 'flex';

                badge.innerText = totalItem;

            } else {

                bar.classList.remove('visible');

                badge.style.display = 'none';

                popupCartItems.innerHTML = '';
            }
        }

        function toggleCartPopup() {
            let popup = document.getElementById('cartPopup');
            popup.classList.toggle('visible');
        }

        // SEARCH
        function filterProducts() {

            let q =
                document.getElementById('searchInput')
                .value.toLowerCase();

            document.querySelectorAll('.card')
                .forEach(card => {

                    let name = card.dataset.name || '';

                    card.style.display =
                        name.includes(q) ?
                        '' :
                        'none';
                });
        }

        // CATEGORY
        function filterCategory(slug, btn) {

            document.querySelectorAll('.cat-btn')
                .forEach(b => b.classList.remove('active'));

            btn.classList.add('active');

            document.querySelectorAll('.card')
                .forEach(card => {

                    if (
                        slug === 'all' ||
                        card.dataset.category === slug
                    ) {

                        card.style.display = '';

                    } else {

                        card.style.display = 'none';
                    }
                });
        }

        // SCROLL CART
        function scrollToCart() {

            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        }
    </script>

</body>

</html>
