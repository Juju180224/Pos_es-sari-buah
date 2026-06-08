@extends('layouts.auth')

@section('css')
    <style>
        .invalid-feedback {
            display: block;
        }

        body.login-page {
            background: #f4f6f9;
        }

        .login-box {
            width: 420px;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-card-body {
            padding: 35px;
            border-radius: 20px;
        }

        .login-logo-custom {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-logo-custom img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #28a745;
            background: #fff;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .15);
        }

        .login-title {
            font-size: 34px;
            font-weight: 700;
            color: #28a745;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .login-subtitle {
            color: #6c757d;
            font-size: 15px;
            margin-bottom: 25px;
        }

        .form-control {
            height: 48px;
            border-radius: 8px;
        }

        .input-group-text {
            border-radius: 0 8px 8px 0;
            background: #fff;
        }

        .btn-success {
            height: 48px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
        }

        .btn-success:hover {
            background: #218838;
        }

        .icheck-primary label {
            font-weight: 500;
        }

        .login-links {
            text-align: center;
            margin-top: 20px;
        }

        .login-links a {
            display: block;
            margin-bottom: 10px;
            font-size: 15px;
        }

        @media (max-width: 576px) {
            .login-box {
                width: 95%;
            }

            .login-card-body {
                padding: 25px;
            }

            .login-title {
                font-size: 28px;
            }
        }
    </style>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
@endsection

@section('content')
    <div class="login-logo-custom">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Es Sari Buah">

        <div class="login-title">
            Es Sari Buah
        </div>

        <div class="login-subtitle">
            Selamat Datang di Sistem Penjualan Es Sari Buah
        </div>
    </div>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <!-- EMAIL -->
        <div class="form-group">
            <div class="input-group">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Masukkan Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- PASSWORD -->
        <div class="form-group">
            <div class="input-group">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan Kata Sandi" required autocomplete="current-password">

                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- REMEMBER + BUTTON -->
        <div class="row align-items-center">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <div class="col-5">
                <button type="submit" class="btn btn-success btn-block">
                    Masuk
                </button>
            </div>
        </div>
    </form>

    <div class="login-links">
        <a href="{{ route('password.request') }}">
            Lupa Kata Sandi?
        </a>

        <a href="{{ route('register') }}">
            Daftar Akun Baru
        </a>
    </div>
@endsection
