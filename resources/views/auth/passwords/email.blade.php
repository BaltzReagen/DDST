<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Kata Laluan</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="login">
    @include('components.logo-header')
    <div class="back-button">
        <button class="back-btn" onclick="window.location='{{ route('login') }}'"><span>←</span> Kembali</button>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h1>Reset Kata Laluan</h1>

            <div class="alert alert-info">
                <p>Nota: Jika anda mendaftar menggunakan Google, sila gunakan butang "Login dengan Google" di halaman log masuk.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="login-form-group">
                    <label for="email">Emel</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           placeholder="Masukkan emel anda" required autofocus>
                </div>

                <button type="submit" class="login-page-btn">
                    Hantar Pautan Reset Kata Laluan
                </button>
            </form>
        </div>
    </div>

    <footer class="login-footer">
        <p>&copy; 2024 - Kevin - All Rights Reserved</p>
    </footer>
</body>
</html>