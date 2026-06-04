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
    <audio id="notifSound" src="{{ asset('public/mlbb-new-message-notification.mp3') }}"></audio>

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
        let lastOrderId = 0;

        function checkOrder() {
            fetch('/api/check-order')
                .then(res => res.json())
                .then(data => {

                    if (data.id && data.id !== lastOrderId) {
                        lastOrderId = data.id;

                        // bunyi
                        document.getElementById('notifSound').play();

                        // tampil notif
                        let box = document.getElementById('notifBox');
                        box.style.display = 'block';

                        setTimeout(() => {
                            box.style.display = 'none';
                        }, 3000);
                    }

                });
        }

        // cek tiap 3 detik
        setInterval(checkOrder, 3000);
    </script>

    @yield('js')
    @yield('model')

</body>

</html>
