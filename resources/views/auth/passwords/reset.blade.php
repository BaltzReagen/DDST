<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Kata Laluan</title>
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="login-form-group">
                    <label for="email">Emel</label>
                    <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" 
                           required autocomplete="email" autofocus>
                </div>

                <div class="login-form-group">
                    <label for="password">Kata Laluan Baru</label>
                    <input type="password" name="password" id="password" 
                           placeholder="Masukkan kata laluan baru" required>
                </div>

                <div class="login-form-group">
                    <label for="password-confirm">Sahkan Kata Laluan Baru</label>
                    <input type="password" name="password_confirmation" id="password-confirm" 
                           placeholder="Sahkan kata laluan baru" required>
                </div>

                <button type="submit" class="login-page-btn">
                    Reset Kata Laluan
                </button>
            </form>
        </div>
    </div>

    <footer class="login-footer">
        <p>&copy; 2024 - Kevin - All Rights Reserved</p>
    </footer>
</body>
</html>