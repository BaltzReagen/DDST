<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <title>Assessment Result</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Add Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Add Modern Font -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Add Mapbox CSS -->
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
        <!-- Add Mapbox JS -->
        <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
        <style>         
            .result-header {
                background: linear-gradient(135deg, #6c549c, #9c54b8);
                color: white;
                padding: 2rem;
                border-radius: 16px;
                margin-bottom: 2rem;
                box-shadow: 0 4px 15px rgba(108, 84, 156, 0.2);
            }

            .result-card {
                background: white;
                padding: 2rem;
                border-radius: 16px;
                margin-bottom: 2rem;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
                transition: transform 0.2s;
            }

            .result-card:hover {
                transform: translateY(-2px);
            }

            .detail-label {
                color: #6c757d;
                font-size: 0.9rem;
                font-weight: 500;
                margin-bottom: 0.3rem;
            }

            .detail-value {
                font-size: 1.1rem;
                font-weight: 600;
                color: #2d3436;
                margin-bottom: 1rem;
            }

            .developmental-age {
                font-size: 2rem;
                font-weight: 700;
                color: #6c549c;
                margin: 1rem 0;
            }

            .action-buttons {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
                margin-top: 2rem;
            }

            .action-btn {
                padding: 0.8rem 1.5rem;
                border-radius: 12px;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.2s;
            }

            .action-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .alert {
                border: none;
                border-radius: 12px;
                padding: 1.2rem;
            }

            .alert-success {
                background-color: #d4edda;
                color: #155724;
            }

            .alert-warning {
                background-color: #fff3cd;
                color: #856404;
            }

            #map {
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            }

            .healthcare-info {
                background: #f8f9fa;
                padding: 1.5rem;
                border-radius: 12px;
                margin-top: 1rem;
            }

            .emoji-container {
                padding: 2rem;
                background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                border-radius: 16px;
                text-align: center;
            }

            .emoji-image {
                max-width: 200px;
                filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
            }

            .loading {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(255, 255, 255, 0.9);
                padding: 1rem;
                border-radius: 8px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            }

            .custom-marker {
                background-color: #FF0000;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                cursor: pointer;
                border: 2px solid white;
                box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            }

            .user-marker {
                background-color: #4834d4;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                cursor: pointer;
                border: 2px solid white;
                box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            }

            .mapboxgl-popup {
                max-width: 300px;
            }

            .popup-content {
                padding: 10px;
            }

            .popup-content h6 {
                margin: 0 0 5px 0;
                font-size: 14px;
                font-weight: 600;
            }

            .popup-content p {
                margin: 0 0 10px 0;
                font-size: 12px;
                color: #666;
            }

            .direction-btn {
                background: #4834d4;
                color: white;
                border: none;
                padding: 5px 10px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 12px;
                width: 100%;
            }

            .loading1 {
                opacity: 0.7;
                cursor: wait;
                pointer-events: none;
            }

            .loading1 span::after {
                content: '...';
                animation: loading 1s infinite;
            }

            @keyframes loading1 {
                0% { content: '.'; }
                33% { content: '..'; }
                66% { content: '...'; }
            }

            .loading1 {
                opacity: 0.8;
                position: relative;
            }

            .loading1 span::after {
                content: '...';
                display: inline-block;
                animation: loading 1.5s infinite;
            }

            @keyframes loading {
                0% { content: '.'; }
                33% { content: '..'; }
                66% { content: '...'; }
            }

            /* Regular header logo */
            .main-header .site-logo {
                height: 150px;
                width: auto;
            }

            .result-page .logo-container {
                display: flex;
                justify-content: center;
                padding: 0.5rem 0;
                margin-bottom: 0;
            }

            .result-page .site-logo {
                height: 150px;
                width: auto;
                margin-bottom: 0.5rem;
            }

            @media (max-width: 768px) {
                .container {
                    padding: 1rem;
                }

                .result-header,
                .result-card {
                    padding: 1.5rem;
                }

                .developmental-age {
                    font-size: 2rem;
                }

                .action-btn {
                    width: 100%;
                }
            }

            /* Result page specific styles */
            .result-page {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                background-color: #f8f9fa;
            }

            .container.py-5 {
                flex: 1;
                display: flex;
                flex-direction: column;
                padding-top: 0.01rem !important;
            }

            footer {
                width: 100%;
                background-color: white;
                text-align: center;
                padding: 20px 0;
                color: #6b7280;
                box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1);
                margin-top: auto;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('css/result.css') }}">
    </head>

    <body class="result-page">

        <div class="background-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="logo-container">
            <a href="{{ Auth::check() && !Auth::user()->isGuest ? route('dashboard') : url('/') }}" class="logo-wrapper">
                <img src="{{ asset('images/logo.png') }}" alt="DDST Logo" class="site-logo">
            </a>
        </div>

        <div class="container py-5">
            <div class="result-header text-center">
                <h1 class="display-5 fw-bold mb-0">Keputusan Penilaian</h1>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="result-card">
                        <h4>Maklumat Anak Anda:</h4>
                        <div class="detail-label">Nama</div>
                        <div class="detail-value">{{ $screening->child_name }}</div>
                        
                        <div class="detail-label">Tarikh Lahir</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($screening->child_dob)->format('Y-m-d') }}</div>
                        
                        <div class="detail-label">Jantina</div>
                        <div class="detail-value">{{ $screening->child_gender === 'M' ? 'Lelaki' : 'Perempuan' }}</div>

                        <hr class="my-4">

                        <h4>Umur Perkembangan</h4>
                        <div class="developmental-age">
                            @php
                                $years = floor($developmentalAge / 12);
                                $months = $developmentalAge % 12;
                            @endphp
                            
                            @if($screening->child_age_in_months == 0)
                                @if($hasDelay)
                                    Kurang dari 1 Bulan
                                @else
                                    1 Bulan
                                @endif
                            @elseif($developmentalAge < 12)
                                {{ $developmentalAge }} Bulan
                            @else
                                @if($months == 0)
                                    {{ $years }} Tahun
                                @else
                                    {{ $years }} Tahun {{ $months }} Bulan
                                @endif
                            @endif
                        </div>

                        @if($hasDelay)
                            <div class="alert alert-warning">
                                <i class="material-icons">info</i>
                                <p class="mb-0">
                                    Berdasarkan penilaian, umur perkembangan anak anda adalah 
                                    @if($screening->child_age_in_months == 0)
                                        @if($hasDelay)
                                            kurang dari 1 bulan
                                        @else
                                            1 bulan
                                        @endif
                                    @elseif($developmentalAge < 12)
                                        {{ $developmentalAge }} bulan
                                    @else
                                        @php
                                            $years = floor($developmentalAge / 12);
                                            $months = $developmentalAge % 12;
                                        @endphp
                                        @if($months == 0)
                                            {{ $years }} tahun
                                        @else
                                            {{ $years }} tahun {{ $months }} bulan
                                        @endif
                                    @endif
                                    , iaitu di bawah umur sebenar. Kami mencadangkan untuk berunding dengan profesional kesihatan untuk penilaian lanjut.
                                </p>
                            </div>
                        @else
                            <div class="alert alert-success">
                                <i class="material-icons">check_circle</i>
                                <p class="mb-0">Perkembangan anak anda kelihatan sesuai dengan umurnya.</p>
                            </div>
                        @endif
                    </div>

                    @if(!Auth::check())
                    <div class="alert alert-info mt-4">
                        <i class="material-icons">account_circle</i>
                        <p class="mb-0">Daftar akaun untuk:</p>
                        <ul>
                            <li>Menyimpan saringan masa hadapan dalam akaun anda</li>
                            <li>Melihat sejarah saringan pada bila-bila masa</li>
                            <li>Memantau perkembangan anak anda</li>
                        </ul>
                    </div>
                    @endif

                    <div class="action-buttons">
                        @php
                            use Illuminate\Support\Facades\Log;

                            $route = Auth::check() && $isViewingHistory 
                                ? route('questionnaire.retry', ['screeningId' => $screening->id]) 
                                : route('retake.test');

                            Log::info('Activated route: ' . $route);
                        @endphp

                        @if($isViewingHistory)
                            <a href="{{ route('questionnaire.retry', ['screeningId' => $screening->id]) }}" 
                            class="btn btn-warning action-btn">
                                <i class="material-icons">replay</i> Retake from History
                            </a>
                        @else
                            <!-- Original button for other contexts -->
                            <a href="{{ route('retake.test') }}" class="btn btn-warning action-btn">
                                <i class="material-icons">replay</i> Ulang Ujian
                            </a>
                        @endif

                        <a href="{{ route('print.result', ['screeningId' => $screening->id]) }}" 
                            class="btn btn-info action-btn"
                            target="_blank" 
                            onclick="handlePdfDownload(event, this)">
                            <i class="material-icons">download</i> 
                            <span>Muat Turun PDF</span>
                        </a>

                        @guest
                            @if(!Auth::check())
                            <a href="{{ route('signup') }}" class="btn btn-primary action-btn">
                                <i class="material-icons">person_add</i> Daftar Akaun
                            </a>
                            @endif
                        @endguest
                    </div>
                </div>

                <div class="col-lg-6">
                    @if($hasDelay)
                        <div class="result-card">
                            <h4 class="fw-bold mb-4">LOKASI PUSAT KESIHATAN</h4>
                            <div id="map" style="height: 300px;"></div>
                            <div id="medical-center-info" class="healthcare-info">
                                <p class="text-center text-muted">Pin ungu menunjukkan lokasi anda sekarang. Klik pada pin pusat kesihatan untuk melihat maklumat</p>
                            </div>
                        </div>
                    @else
                        <div class="result-card">
                            <div class="emoji-container">
                                <img src="{{ asset('images/good_job.png') }}" alt="Happy Result" class="emoji-image">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>



        @if($hasDelay)
            <script>
                function handlePdfDownload(event, button) {
                    // Add loading class
                    button.classList.add('loading1');
                    
                    // Remove loading class after a short delay
                    setTimeout(() => {
                        button.classList.remove('loading1');
                    }, 1000);
                }

                mapboxgl.accessToken = '{{ config('services.mapbox.public_token') }}';
                let currentMap = null;
                let selectedFacility = null;
                let markers = [];

                // Initialize map
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        initializeMap([position.coords.longitude, position.coords.latitude]);
                    },
                    (error) => {
                        // Default to Putrajaya if location access denied
                        initializeMap([101.6965, 2.9235]);
                    }
                );

                function initializeMap(centerCoordinates) {
                    const map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/streets-v12',
                        center: centerCoordinates,
                        zoom: 12
                    });
                    
                    currentMap = map;

                    map.on('load', () => {
                        // Add navigation controls
                        map.addControl(new mapboxgl.NavigationControl());

                        // Add user location marker
                        const userLocationEl = document.createElement('div');
                        userLocationEl.className = 'user-marker';
                        new mapboxgl.Marker(userLocationEl)
                            .setLngLat(centerCoordinates)
                            .addTo(map);

                        // Search for medical facilities
                        searchNearbyMedicalFacilities(centerCoordinates);
                    });
                }

                async function searchNearbyMedicalFacilities(centerCoordinates) {
                    try {
                        // Show loading indicator
                        const loadingDiv = document.createElement('div');
                        loadingDiv.className = 'loading-indicator';
                        loadingDiv.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
                        document.getElementById('map').appendChild(loadingDiv);

                        // Clear existing markers
                        markers.forEach(marker => marker.remove());
                        markers = [];

                        // More comprehensive search terms for Malaysian healthcare facilities
                        const searchTypes = [
                            'hospital',
                            'klinik',
                            'pusat+kesihatan',
                            'medical+center',
                            'health+clinic',
                            'klinik+kesihatan',
                            'hospital+swasta',
                            'poliklinik'
                        ];

                        const searchPromises = searchTypes.map(type => 
                            fetch(
                                `https://api.mapbox.com/geocoding/v5/mapbox.places/${type}.json?` +
                                `proximity=${centerCoordinates[0]},${centerCoordinates[1]}&` +
                                `country=my&` +
                                `types=poi&` +
                                `limit=50&` + // Increased from 25 to 50
                                `access_token=${mapboxgl.accessToken}`
                            ).then(response => response.json())
                        );

                        // Execute all searches in parallel
                        const results = await Promise.all(searchPromises);
                        
                        // Combine and deduplicate results
                        const seenPlaces = new Set();
                        
                        results.forEach(data => {
                            if (data.features) {
                                data.features.forEach(facility => {
                                    const placeId = facility.id;
                                    
                                    // Skip if we've already added this place
                                    if (seenPlaces.has(placeId)) return;
                                    seenPlaces.add(placeId);

                                    const distance = calculateDistance(
                                        centerCoordinates[1],
                                        centerCoordinates[0],
                                        facility.center[1],
                                        facility.center[0]
                                    );

                                    // Show facilities within 50km radius
                                    if (distance <= 50) {
                                        addMarkerToMap(facility, distance, centerCoordinates);
                                    }
                                });
                            }
                        });

                        // Remove loading indicator
                        loadingDiv.remove();

                    } catch (error) {
                        console.error('Error fetching medical facilities:', error);
                        // Remove loading indicator in case of error
                        document.querySelector('.loading-indicator')?.remove();
                    }
                }

                function addMarkerToMap(facility, distance, centerCoordinates) {
                    // Create marker element
                    const el = document.createElement('div');
                    el.className = 'custom-marker';

                    // Create popup
                    const popup = new mapboxgl.Popup({ offset: 25 })
                        .setHTML(`
                            <div class="popup-content">
                                <h6>${facility.text}</h6>
                                <p>${facility.place_name}</p>
                                <p>${distance.toFixed(1)} km away</p>
                                <button onclick="getDirections(${facility.center[1]}, ${facility.center[0]})" class="direction-btn">
                                    Get Directions
                                </button>
                            </div>
                        `);

                    // Create and add marker
                    const marker = new mapboxgl.Marker(el)
                        .setLngLat(facility.center)
                        .setPopup(popup)
                        .addTo(currentMap);

                    markers.push(marker);
                }

                function calculateDistance(lat1, lon1, lat2, lon2) {
                    const R = 6371; // Earth's radius in km
                    const dLat = deg2rad(lat2 - lat1);
                    const dLon = deg2rad(lon2 - lon1);
                    const a = 
                        Math.sin(dLat/2) * Math.sin(dLat/2) +
                        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                        Math.sin(dLon/2) * Math.sin(dLon/2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                    return R * c;
                }

                function deg2rad(deg) {
                    return deg * (Math.PI/180);
                }

                function getDirections(lat, lng) {
                    window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`, '_blank');
                }
            </script>

            <!-- Add info box container below map -->
            <div id="medical-center-info" style="display: none;">
                <div class="info-content">
                    <h4 id="facility-name"></h4>
                    <div id="facility-type" class="facility-type"></div>
                    <div id="facility-address" class="address"></div>
                    <div id="facility-distance" class="distance"></div>
                    <button id="direction-btn" class="direction-btn" onclick="openDirections()">
                        Get Directions
                    </button>
                </div>
            </div>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Clear any existing history
                window.history.pushState(null, '', window.location.href);
                
                // Replace current state
                window.history.replaceState({page: 'result'}, '', window.location.href);
                
                // Handle navigation attempts
                window.addEventListener('popstate', function(event) {
                    window.location.href = '{{ route("form") }}';
                });

                // Disable keyboard navigation
                window.addEventListener('keydown', function(e) {
                    if ((e.key === 'Backspace' && !isInputActive(e.target)) || 
                        (e.key === 'ArrowLeft' && e.altKey) || 
                        (e.key === 'ArrowRight' && e.altKey)) {
                        e.preventDefault();
                        window.location.href = '{{ route("form") }}';
                        return false;
                    }
                });

                // Helper function to check if user is typing in an input field
                function isInputActive(element) {
                    return element.tagName === 'INPUT' || 
                           element.tagName === 'TEXTAREA' || 
                           element.isContentEditable;
                }
            });

            // Prevent bfcache
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    window.location.href = '{{ route("form") }}';
                }
            });

            // Clear storage
            sessionStorage.clear();
            localStorage.removeItem('questionnaire_progress');
        </script>

        <footer>
            <small>&copy; {{ date('Y') }} NARC - All Rights Reserved</small>
        </footer>
    </body>
</html>
