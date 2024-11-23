<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>

    <!-- Fonts -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        function validatePasswords(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if(password.length < 8){
                event.preventDefault();
                alert('Kata laluan mestilah sekurang-kurangnya 8 aksara!');
                document.getElementById('password').value='';
                document.getElementById('confirm-password').value='';
            }

            if (password !== confirmPassword) {
                event.preventDefault(); // Prevent form submission
                alert('Kata laluan tidak sepadan!'); // Show alert message
                document.getElementById('password').value='';
                document.getElementById('confirm-password').value='';
            }
        }
    </script>
</head>

<body>
    @include('components.logo-header')

    <div class="background-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="login">
        <div class="back-button">
            <button class="back-btn" onclick="window.location='{{ url('form') }}'"><span>←</span> Kembali</button>
        </div>

        <div class="login-container">
            <div class="login-box">
                <h1>Cipta Akaun</h1>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Registration Form -->
                <form action="{{ route('register.store') }}" method="POST" onsubmit="validatePasswords(event)">
                    @csrf
                    <div class="login-form-group">
                        <label for="username">Nama Pengguna <span class="required-indicator">*</span></label>
                        <input type="text" id="username" name="username" 
                               value="{{ old('username') }}" 
                               placeholder="Masukkan Nama Pengguna" required>
                    </div>
                    <div class="login-form-group">
                        <label for="email">Emel <span class="required-indicator">*</span></label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email') }}" 
                               placeholder="Masukkan Emel" required>
                    </div>
                    <div class="login-form-group">
                        <label for="password">Kata Laluan <span class="required-indicator">*</span></label>
                        <input type="password" name="password" id="password" 
                               placeholder="Masukkan Kata Laluan (minimum 8 aksara)" required>
                    </div>
                    <div class="login-form-group">
                        <label for="confirm-password">Sahkan Kata Laluan <span class="required-indicator">*</span></label>
                        <input type="password" name="password_confirmation" id="confirm-password" 
                               placeholder="Sahkan Kata Laluan" required>
                    </div>
                    <button type="submit" class="login-page-btn">DAFTAR</button>
                </form>

                <div class="login-options">
                    <div class="register-divider-container">
                        <div class="register-divider"></div>
                        <span class="register-divider-text">atau</span>
                        <div class="register-divider"></div>
                    </div>
                </div>

                <a href="{{ route('google.login') }}" class="google-btn">
                    <img src="{{ asset('images/google-logo.png') }}" alt="Google Icon" class="google-icon">
                    Daftar dengan Google
                </a>
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
