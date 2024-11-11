<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DDST</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>
    <body>
        @include('components.logo-header')
        <div class="hero-section">
            <h1 class="hero-title">Alat Saringan Perkembangan Kanak-kanak</h1>
            
            <div class="content-grid">
                <div class="info-card">
                    <h2>Apakah itu Alat Saringan Perkembangan Kanak-kanak?</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pharetra ligula a enim fringilla, nec commodo dolor tincidunt.</p>
                    <button class="cta-button" id="cta-button">Mulakan Ujian Sekarang!</button>
                </div>

                <div class="info-card">
                    <h2>Important Notice</h2>
                    <p>Nam elementum tincidunt ultricies. Morbi vitae massa sed purus placerat sagittis non eu nibh. Fusce condimentum egestas aliquet. In sit amet lobortis orci, pharetra viverra purus.</p>
                </div>
            </div>
        </div>

        <footer>
            <p>&copy; 2024 - Kevin - All Rights Reserved</p>
        </footer>

        <script>
            document.getElementById('cta-button').addEventListener('click', function(){
                window.location = '{{ url('form') }}';
            });
        </script>
    </body>
</html>
