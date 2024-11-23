<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Dashboard</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">
    </head>
    
    <body class="dashboard-body">
        @include('components.logo-header')

        <div class="background-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="dashboard-container">
            <main class="dashboard-main">
                <div class="dashboard-content">
                    <h2>Papan Pemuka</h2>
                    <div class="dashboard-cards">
                        <div class="dashboard-card" onclick="viewPastResults()">
                            <div class="card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3>Lihat Keputusan Lepas</h3>
                            <p>Akses keputusan saringan terdahulu dan jejaki kemajuan</p>
                            <div class="card-action">
                                Lihat Keputusan 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>

                        <div class="dashboard-card" onclick="useScreeningTool()">
                            <div class="card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <h3>Saringan Baharu</h3>
                            <p>Mulakan penilaian saringan perkembangan baharu</p>
                            <div class="card-action">
                                Mulakan Saringan
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <footer class="dashboard-footer">
            <p>&copy; 2024 Kevin - All Rights Reserved</p>
        </footer>

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