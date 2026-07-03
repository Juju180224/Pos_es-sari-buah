<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('settings.app_name') ?? config('app.name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('css')

    <script>
        window.APP = <?php echo json_encode([
            'currency_symbol' => config('settings.currency_symbol'),
            'warning_quantity' => config('settings.warning_quantity'),
        ]); ?>
    </script>

    {{-- SOUND --}}
    <audio id="notifSound" src="{{ asset('mlbb-new-message-notification.mp3') }}" preload="auto"></audio>

    <style>
        .notif-box {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #27ae60;
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            display: none;
            z-index: 9999;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        @include('layouts.partials.navbar')
        @include('layouts.partials.sidebar')

        <div class="content-wrapper">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('content-header')</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            @yield('content-actions')
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                @include('layouts.partials.alert.success')
                @include('layouts.partials.alert.error')
                @yield('content')
            </section>

        </div>

        @include('layouts.partials.footer')

    </div>

    {{-- NOTIF POPUP --}}
    <div class="notif-box" id="notifBox">
        Pesanan baru masuk!
    </div>

    {{-- REALTIME SCRIPT --}}
    <script>
        let lastOrderId = null;

        // unlock autoplay: browser butuh 1 interaksi user dulu sebelum audio bisa auto play
        document.addEventListener('click', function unlockAudio() {
            let audio = document.getElementById('notifSound');
            audio.play().then(() => {
                audio.pause();
                audio.currentTime = 0;
            }).catch(() => {});
            document.removeEventListener('click', unlockAudio);
        }, {
            once: true
        });

        function checkOrder(isFirstLoad = false) {
            fetch('{{ route('admin.orders.latest') }}')
                .then(res => res.json())
                .then(data => {

                    if (!data.id) return;

                    // load pertama kali: cuma catat id, jangan bunyi
                    if (isFirstLoad) {
                        lastOrderId = data.id;
                        return;
                    }

                    if (data.id !== lastOrderId) {
                        lastOrderId = data.id;

                        // bunyi
                        document.getElementById('notifSound').play().catch(e => {
                            console.log('Autoplay diblokir, perlu interaksi user dulu:', e);
                        });

                        // tampil notif
                        let box = document.getElementById('notifBox');
                        box.innerHTML = 'Pesanan baru masuk! #' + data.id +
                            (data.customer_name ? ' - ' + data.customer_name : '');
                        box.style.display = 'block';

                        setTimeout(() => {
                            box.style.display = 'none';
                        }, 4000);
                    }

                })
                .catch(err => console.error('Gagal cek pesanan:', err));
        }

        // load pertama: ambil id terakhir tanpa bunyi
        checkOrder(true);

        // cek tiap 3 detik setelahnya
        setInterval(() => checkOrder(false), 3000);
    </script>

    @yield('js')
    @yield('model')

</body>

</html>
