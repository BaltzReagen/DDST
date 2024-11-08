<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Dashboard</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    </head>
    
    <body class="dashboard-body">
        <div class="dashboard-container">
            <header class="dashboard-header">
                <div class="header-content">
                    <h1>Selamat Datang, {{ ucfirst(explode(' ', Auth::user()->username)[0]) }}!</h1>
                    <button class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Log Keluar
                    </button>
                </div>
            </header>

            <main class="dashboard-main">
                <div class="dashboard-content">
                    <h2>Papan Pemuka</h2>
                    <div class="dashboard-cards">
                        <div class="dashboard-card" onclick="viewPastResults()">
                            <h3>Lihat Keputusan Lepas</h3>
                            <p>Akses keputusan saringan terdahulu dan jejaki kemajuan</p>
                        </div>

                        <div class="dashboard-card" onclick="useScreeningTool()">
                            <h3>Saringan Baharu</h3>
                            <p>Mulakan penilaian saringan perkembangan baharu</p>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="dashboard-footer">
                <p>&copy; 2024 Kevin - All Rights Reserved</p>
            </footer>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <script>
            function viewPastResults() {
                window.location.href = '/view-results';
            }

            function useScreeningTool() {
                window.location.href = '/screening-tool';
            }

            document.addEventListener("DOMContentLoaded", function() {
                if (!{{ Auth::check() ? 'true' : 'false' }}) {
                    window.location.href = '/login';
                }
            });
        </script>
    </body>
</html>