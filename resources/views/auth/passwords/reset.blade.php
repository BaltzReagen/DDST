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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" onsubmit="validatePasswords(event)">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="login-form-group">
                    <label for="email">Emel <span class="required-indicator">*</span></label>
                    <input type="email" name="email" id="email" 
                           value="{{ $email ?? old('email') }}" 
                           placeholder="Masukkan emel anda"
                           required autocomplete="email" autofocus>
                </div>

                <div class="login-form-group">
                    <label for="password">Kata Laluan Baru <span class="required-indicator">*</span></label>
                    <input type="password" name="password" id="password" 
                           placeholder="Masukkan kata laluan baru (minimum 8 aksara)"
                           required>
                </div>

                <div class="login-form-group">
                    <label for="password-confirm">Sahkan Kata Laluan Baru <span class="required-indicator">*</span></label>
                    <input type="password" name="password_confirmation" id="password-confirm" 
                           placeholder="Sahkan kata laluan baru"
                           required>
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

    <script>
        function validatePasswords(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;
            
            if(password.length < 8) {
                event.preventDefault();
                alert('Kata laluan mestilah sekurang-kurangnya 8 aksara!');
                document.getElementById('password').value = '';
                document.getElementById('password-confirm').value = '';
                return false;
            }
            
            if(password !== confirmPassword) {
                event.preventDefault();
                alert('Kata laluan dan pengesahan kata laluan tidak sepadan!');
                document.getElementById('password').value = '';
                document.getElementById('password-confirm').value = '';
                return false;
            }
            
            return true;
        }

        
    </script>
</body>
</html>