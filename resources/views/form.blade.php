<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Form</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    </head>

    <body>
        <div class="page-container">
            <div class="back-button">
                <button class="back-btn" onclick="window.location='{{ url('/') }}'">
                    <span>←</span> Kembali
                </button>
            </div>

            <div class="form-container">
                <div class="form-header">
                    <h1>Ambil Ujian sebagai Tetamu</h1>
                    <p class="form-description">Sebagai tetamu anda akan mendapat keputusan segera, namun anda akan menerima laporan ujian yang terhad. 
                        Untuk laporan ujian penuh <a href="{{ route('register') }}">daftar di sini</a>.
                    </p>
                    <p class="required-note">* Ruangan wajib diisi</p>
                </div>

                <form class="initial" action="{{ route('screenings.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first-name">Nama Pertama <span class="required">*</span></label>
                            <input type="text" name="fname" id="first-name" placeholder="Masukkan Nama Pertama" required>
                        </div>
                        <div class="form-group">
                            <label for="child-name">Nama Anak <span class="required">*</span></label>
                            <input type="text" name="child_name" id="child-name" placeholder="Masukkan Nama Anak" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Tarikh Lahir <span class="required">*</span></label>
                            <input type="date" name="dob" id="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Jantina <span class="required">*</span></label>
                            <select name="gender" id="gender" required>
                                <option value="" disabled selected>Pilih Jantina</option>
                                <option value="M">Lelaki</option>
                                <option value="F">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <button class="primary-btn" type="submit">Ambil Ujian</button>
                </form>

                <div class="account-options">
                    <div class="divider">
                        <span>ATAU</span>
                    </div>
                    
                    <div class="auth-buttons">
                        <button class="secondary-btn" id="register-btn">Daftar untuk Akses Penuh</button>
                        <p class="login-text">Sudah mempunyai akaun? <button class="text-btn" id="login-btn">Log masuk</button></p>
                    </div>
                </div>
            </div>

            <footer class="login-footer">
                <p>&copy; 2024 - Kevin - All Rights Reserved</p>
            </footer>
        </div>

        <script>
            document.getElementById('login-btn').addEventListener('click', () => window.location = '{{ url('login') }}');
            document.getElementById('register-btn').addEventListener('click', () => window.location = '{{ url('register') }}');
        </script>
    </body>
</html>