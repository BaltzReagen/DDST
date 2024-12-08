<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

        <!-- Fonts -->
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body class="login">
        @include('components.logo-header')

        <div class="background-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="back-button">
            <button class="back-btn" onclick="window.location='{{ url('form') }}'"><span>←</span> Kembali</button>
        </div>

        <div class="login-container">
            <div class="login-box">
                <h1>LOG MASUK</h1>

                @if(session('google_login_error'))
                    <div class="alert alert-danger">
                        {{ session('google_login_error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
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
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" 
                                placeholder="Masukkan Kata Laluan" required>
                            <button type="button" id="toggle-password" 
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none;">
                                <i class="fas fa-eye" id="toggle-icon"></i>
                            </button>
                        </div>
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
                    <a href="{{ route('password.request') }}" class="auth-link">Lupa Kata Laluan?</a>
                    <a href="{{ route('register') }}" class="auth-link">Daftar</a>
                </div>
            </div>
        </div>

        <footer class="login-footer">
            <p>&copy; 2024 - Kevin - All Rights Reserved</p>
        </footer>

        <script>
            const togglePassword = document.getElementById('toggle-password');
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.back-btn').addEventListener('click', function(){
                    window.location = '{{ url("form") }}';
                });
            });

            togglePassword.addEventListener('mousedown', function() {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            });

            togglePassword.addEventListener('mouseup', function() {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            });

            togglePassword.addEventListener('mouseleave', function() {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            });
        </script>
    </body>
</html>