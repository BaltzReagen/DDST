<header class="main-header">
    <div class="header-container">
        <div class="logo-wrapper">
            <a href="{{ Auth::check() ? route('dashboard') : url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="DDST Logo" class="site-logo">
            </a>
        </div>
        
        @auth
            <div class="header-content">
                <h1>Selamat Datang, {{ App\Helpers\StringHelper::extractFirstName(Auth::user()->username) }}!</h1>
                <button class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Log Keluar
                </button>
            </div>
        @endauth
    </div>
</header>

<!-- Add the logout form here, outside the header -->
@auth
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth