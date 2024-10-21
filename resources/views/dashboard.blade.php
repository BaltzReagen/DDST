<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, {{ ucfirst(explode(' ', Auth::user()->username)[0]) }}!</h1>
            <button class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">LOG OUT</button>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </header>
        <main>
            <div class="dashboard">
                <h2>DASHBOARD</h2>
                <div class="buttons">
                    <button class="btn primary-btn" onclick="viewPastResults()">VIEW PAST SCREENING RESULT</button>
                    <button class="btn secondary-btn" onclick="useScreeningTool()">USE SCREENING TOOL</button>
                </div>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; Copyright 2024 NABC - All Rights Reserved</p>
    </footer>

    <script>
        // Example of setting username dynamically
        document.getElementById('username').textContent = localStorage.getItem('username') || 'User';

        function viewPastResults() {
            window.location.href = '/view-results';
        }

        function useScreeningTool() {
            window.location.href = '/screening-tool';
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the user is authenticated (adjust according to your logic)
            if (!{{ Auth::check() ? 'true' : 'false' }}) {
                // Redirect to the login page
                window.location.href = '/login';
            }
        });
    </script>
</body>
</html>