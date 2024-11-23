<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DDST</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <style>
            body {
                background: linear-gradient(135deg, #fff5f5 0%, #fff0ea 100%);
                position: relative;
                overflow-x: hidden;
            }

            .banner-section {
                position: relative;
                width: 100%;
                height: 250px;
                overflow: hidden;
                margin-bottom: 2rem;
            }

            .banner-image {
                width: 100%;
                height: 120%;
                object-fit: cover;
                object-position: center 20%;
                filter: brightness(0.7) sepia(20%) saturate(110%);
            }

            .banner-title {
                color: white;
                font-size: 2.5rem;
                font-weight: 700;
                text-align: center;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
                padding: 0 1rem;
                position: relative;
                top: 30px;
            }

            .banner-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(
                    rgba(255, 166, 0, 0.2),
                    rgba(0, 0, 0, 0.5)
                );
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .content-section {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
                display: flex;
                gap: 2rem;
                align-items: flex-start;
            }

            .info-card {
                flex: 1;
                background: white;
                border-radius: 12px;
                padding: 2rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .features-grid {
                flex: 1;
                display: grid;
                gap: 1rem;
            }

            .feature-card {
                background: white;
                border-radius: 12px;
                padding: 1.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .cta-button {
                background: #6c549c;
                color: white;
                border: none;
                padding: 1rem 2rem;
                font-size: 1.1rem;
                font-weight: 600;
                border-radius: 8px;
                cursor: pointer;
                transition: all 0.2s ease;
                display: block;
                width: 100%;
                margin-top: 1.5rem;
            }

            .cta-button:hover {
                background: #9c54b8;
                transform: translateY(-2px);
            }

            @media (max-width: 768px) {
                .content-section {
                    flex-direction: column;
                }
                .banner-title {
                    font-size: 2rem;
                }
            }
        </style>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>
    <body>
        @include('components.logo-header')

        <div class="background-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="banner-section">
            <img src="{{ asset('images/welcome_banner.jpg') }}" alt="Children Banner" class="banner-image">
            <div class="banner-overlay">
                <h1 class="banner-title">Alat Saringan Perkembangan Kanak-kanak</h1>
            </div>
        </div>

        <div class="content-section">
            <div class="info-card">
                <h2>Apakah itu Alat Saringan Perkembangan Kanak-kanak?</h2>
                <p>Alat Saringan Perkembangan Kanak-kanak adalah alat penilaian yang direka untuk membantu ibu bapa dan penjaga mengenal pasti potensi kelewatan perkembangan pada kanak-kanak. Alat ini menilai pelbagai aspek perkembangan termasuk kemahiran motor kasar, motor halus, bahasa, dan sosial.</p>
                <button class="cta-button" id="cta-button">Mulakan Ujian Sekarang!</button>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <h3>Penilaian Komprehensif</h3>
                    <p>Menilai pelbagai aspek perkembangan kanak-kanak termasuk motor kasar, motor halus, bahasa, dan kemahiran sosial.</p>
                </div>
                <div class="feature-card">
                    <h3>Mudah Digunakan</h3>
                    <p>Antara muka yang mesra pengguna dan arahan yang jelas memudahkan proses penilaian.</p>
                </div>
                <div class="feature-card">
                    <h3>Keputusan Segera</h3>
                    <p>Dapatkan keputusan dan cadangan segera selepas melengkapkan penilaian.</p>
                </div>
            </div>
        </div>

        <footer class="login-footer">
            <p>&copy; 2024 - Kevin - All Rights Reserved</p>
        </footer>

        <script>
            document.getElementById('cta-button').addEventListener('click', function() {
                window.location.href = '{{ route("form") }}';
            });
        </script>
    </body>
</html>