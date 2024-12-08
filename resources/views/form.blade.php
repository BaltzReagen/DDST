<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <title>Form</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/form.css') }}">
    </head>

    <body>
        @include('components.logo-header')
        @php
            // Clear all screening related sessions
            Session::forget('questionnaire_completed');
            Session::forget('screening_in_progress');
            foreach (Session::all() as $key => $value) {
                if (Str::startsWith($key, ['completed_screening_', 'last_failed_age_group_', 'has_delay_', 'original_age_', 'final_developmental_age_'])) {
                    Session::forget($key);
                }
            }
        @endphp

        <div class="background-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="page-container">
            <div class="form-container">
                <div class="form-header">
                    <h1>Alat Saringan Perkembangan Kanak-kanak</h1>
                        <p>Nota: Alat ini hanya meliputi anak-anak dari umur 1 bulan hingga 6 tahun.</p>
                    @auth
                        <p>Sila lengkapkan borang di bawah untuk memulakan saringan perkembangan kanak-kanak.</p>
                    @else
                        <h1>Ambil Ujian sebagai Tetamu</h1>
                        <p class="form-description">Sebagai tetamu anda akan mendapat keputusan segera, namun anda akan menerima laporan ujian yang terhad. 
                            Untuk laporan ujian penuh <a href="{{ route('register') }}">daftar di sini</a>.
                        </p>
                    @endauth
                    
                    <p class="required-note" style="color: crimson"><span>*</span> Ruangan wajib diisi</p>
                </div>

                <form class="initial" action="{{ route('screenings.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first-name">Nama Ibu/Bapa <span class="required-indicator">*</span></label>
                            <input type="text" 
                                id="fname" 
                                name="fname" 
                                value="{{ Auth::check() && Auth::user()->username ? App\Helpers\StringHelper::formatFullName(Auth::user()->username) : old('fname') }}" 
                                placeholder="Masukkan Nama"
                                class="form-control" 
                                required>
                        </div>
                        <div class="form-group">
                            <label for="child-name">Nama Anak <span class="required-indicator">*</span></label>
                            <input type="text" name="child_name" id="child-name" placeholder="Masukkan Nama Anak" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Tarikh Lahir <span class="required-indicator">*</span></label>
                            <input type="date" name="dob" id="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Jantina <span class="required-indicator">*</span></label>
                            <select name="gender" id="gender" required>
                                <option value="" disabled selected>Pilih Jantina</option>
                                <option value="M">Lelaki</option>
                                <option value="F">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <button class="primary-btn" type="submit">Ambil Ujian</button>
                </form>

                @guest
                    <div class="account-options">
                        <div class="divider">
                            <span>ATAU</span>
                        </div>
                        
                        <div class="auth-buttons">
                            <button class="secondary-btn" id="register-btn">Daftar untuk Akses Penuh</button>
                            <p class="login-text">Sudah mempunyai akaun? <button class="text-btn" id="login-btn">Log masuk</button></p>
                        </div>
                    </div>
                @endguest
            </div>
        </div>

        <footer class="login-footer">
            <div class="footer-content">
                <p>&copy; 2024 - Kevin - All Rights Reserved</p>
            </div>
        </footer>

        <script>
            window.onpageshow = function(event) {
                if (event.persisted || sessionStorage.getItem('questionnaire_abandoned') === 'true') {
                    sessionStorage.clear();
                    localStorage.removeItem('questionnaire_progress');
                    window.location.reload();
                }
            };
            
            // Clear browser history state
            if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
                window.location.replace(window.location.href);
            }

            // Prevent back navigation
            window.onpageshow = function(event) {
                if (event.persisted) {
                    window.location.reload();
                }
            };

            // Clear any stored form data
            window.onload = function() {
                sessionStorage.clear();
                localStorage.removeItem('questionnaire_progress');
                
                // Replace the current history entry
                window.history.replaceState(null, '', window.location.href);
            };

            document.getElementById('login-btn').addEventListener('click', () => window.location = '{{ url('login') }}');
            document.getElementById('register-btn').addEventListener('click', () => window.location = '{{ url('register') }}');

            // Prevent form resubmission
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
            
            // Clear any stored questionnaire data
            window.onload = function() {
                sessionStorage.clear();
                localStorage.removeItem('questionnaire_progress');
            }
        </script>

        @php
            // Clear the questionnaire completion session when reaching the form
            Session::forget('questionnaire_completed');
        @endphp
    </body>
</html>