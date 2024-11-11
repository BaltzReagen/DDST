<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>

    <body class="login">
        @include('components.logo-header')
        <div class="back-button">
            <button class="back-btn" onclick="window.location='{{ url('form') }}'"><span>←</span> Kembali</button>
        </div>

        <div class="login-container">
            <div class="login-box">
                <h1>LOG MASUK</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="login-form-group">
                        <label for="email">Emel</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan Emel">
                    </div>
                    <div class="login-form-group">
                        <label for="password">Kata Laluan</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan Kata Laluan">
                    </div>
                    <button type="submit" class="login-page-btn">LOG MASUK</button>
                </form>
                <div class="login-options">
                    <div class="login-divider-container">
                        <div class="login-divider"></div>
                        <span class="login-divider-text">atau</span>
                        <div class="login-divider"></div>
                    </div>
                </div>

                <a href="{{ route('google.login') }}" class="btn-google">
                    <img src="{{ asset('images/google-logo.png') }}" alt="Google logo">
                    <span>Login dengan Google</span>
                </a>

                <div class="auth-links">
                    <a href="{{ route('password.request') }}" class="auth-link">Lupa Masuk?</a>
                    <a href="{{ route('register') }}" class="auth-link">Daftar</a>
                </div>
            </div>
        </div>

        <footer class="login-footer">
            <p>&copy; 2024 - Kevin - All Rights Reserved</p>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.back-btn').addEventListener('click', function(){
                    window.location = '{{ url("form") }}';
                });
            });
        </script>
    </body>
</html>