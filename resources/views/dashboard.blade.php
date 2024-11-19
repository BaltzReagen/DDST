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
        @include('components.logo-header')

        <div class="dashboard-container">
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
                window.location.href = '{{ route("screening.history") }}';
            }

            function useScreeningTool() {
                window.location.href = '{{ route("form") }}';
            }

            document.addEventListener("DOMContentLoaded", function() {
                if (!{{ Auth::check() ? 'true' : 'false' }}) {
                    window.location.href = '/login';
                }
            });
        </script>
    </body>
</html>