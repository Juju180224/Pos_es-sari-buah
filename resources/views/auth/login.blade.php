@extends('layouts.auth')

@section('css')
    <style>
        .invalid-feedback {
            display: block;
        }

        .login-logo-custom {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-logo-custom img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #28a745;
            padding: 4px;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .login-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-top: 12px;
            color: #28a745;
        }

        .login-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
@endsection

@section('content')
    <!-- LOGO -->
    <div class="login-logo-custom">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Es Sari Buah">

        <div class="login-title">
            Es Sari Buah
        </div>

        <div class="login-subtitle">
            Selamat datang di Web Es Sari Buah
        </div>
    </div>

    <form action="{{ route('login') }}" method="post">
        @csrf

        <!-- EMAIL -->
        <div class="form-group">
            <div class="input-group">

                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>

            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- PASSWORD -->
        <div class="form-group">
            <div class="input-group">

                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Kata Sandi" required autocomplete="current-password">

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>

            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- REMEMBER -->
        <div class="row">

            <div class="col-8">
                <div class="icheck-primary">

                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        Ingat Saya
                    </label>

                </div>
            </div>

            <!-- BUTTON -->
            <div class="col-4">
                <button type="submit" class="btn btn-success btn-block">
                    Masuk
                </button>
            </div>

        </div>
    </form>

    <p class="mb-1 mt-3">
        <a href="{{ route('password.request') }}">
            Lupa kata sandi
        </a>
    </p>

    <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">
            Daftar akun baru
        </a>
    </p>
@endsection
