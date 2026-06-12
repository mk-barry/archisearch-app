@props(['sec_css' => '', 'active' => 'dashboard', 'title' => 'ArchiSearch - Admin Dashboard'])

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('css/admin/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">
    @if($sec_css)
        <link rel="stylesheet" href="{{ $sec_css }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>

    <!-- Sidebar display -->
     <script src="{{ asset('js/hambuger.js') }}" defer></script>

    <!-- Select2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <div class="app-container">
        <aside class="main-sidebar" id="main-sidebar">
            
            <div class="sidebar-header">
                <div class="logo-box">AS</div>
                <span class="brand-name">ArchiSearch</span>
                <button class="fermeraside">x</button>
            </div>

            <div class="nav-group">
                <div class="nav-label">Main</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ $active == 'dashboard' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    <span class="link-label">Tableau de bord</span>
                </a>
                <a href="{{ route('admin.evenements') }}" class="nav-item {{ $active == 'evenements' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                    </svg>
                    <span class="link-label">Événements</span>
                </a>
                <a href="{{ route('admin.documents') }}" class="nav-item {{ $active == 'documents' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    <span class="link-label">Documents</span>
                </a>
                <a href="{{ route('admin.recherche') }}" class="nav-item {{ $active == 'recherche' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <span class="link-label">Recherche</span>
                </a>
                <!-- <a href="{{ route('admin.archives') }}" class="nav-item {{ $active == 'archives' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="21 8 21 21 3 21 3 8" />
                        <rect width="22" height="5" x="1" y="3" />
                        <line x1="10" x2="14" y1="12" y2="12" />
                    </svg>
                    <span class="link-label">Archives</span>
                </a> -->
            </div>

            <div class="nav-group">
                <div class="nav-label">Paramètres</div>
                <!-- <a href="{{ route('admin.cloud') }}" class="nav-item {{ $active == 'cloud' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17.5 19A5.5 5.5 0 0 0 18 8.02a1 1 0 0 1-.89-.66 7 7 0 0 0-12.22 0 1 1 0 0 1-.89.66A5.5 5.5 0 0 0 4.5 19Z" />
                    </svg>
                    <span class="link-label">Sauvegarde Cloud</span>
                </a> -->
                <a href="{{ route('profile.edit') }}" class="nav-item {{ $active == 'profil' ? 'active' : '' }}" title="Pofil">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">

                        <path d="M20 21a8 8 0 0 0-16 0" />
                        <circle cx="12" cy="7" r="4" />

                    </svg>
                    <span class="link-label">Profil</span>
                </a>
            </div>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">@csrf</form>
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    <span class="link-label">Déconnexion</span>
                </a>
            </div>
        </aside>

        <!-- <div class="flex-col" style="flex: 1;"> -->
            <div id="overlay" class=""></div>
            <main id="main">
                <div class="mobile-header">
                    <div class="brand-mobile">
                        <div class="logo-box">AS</div>
                        <span class="brand-name">ArchiSearch</span>
                    </div>
                    <button class="hambuger" id="hambuger">
                        <div class="trait"></div>
                        <div class="trait"></div>
                        <div class="trait"></div>
                    </button>
                </div>
                
                <div class="content-wrapper">
                    {{ $slot }}
                </div>
            </main>
        <!-- </div> -->
    </div>
    @stack('scripts')
    @if(session('success'))
    <script>
        ASAlerts.success(@json(session('success')));
    </script>
    @endif
    @if(session('error'))
    <script>
        ASAlerts.error(@json(session('error')));
    </script>
    @endif
</body>

</html>