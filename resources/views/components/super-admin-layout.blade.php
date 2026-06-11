@props(['active' => 'supervision', 'title' => 'ArchiSearch - Dashboard', 'sec_css' => ''])

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/super-admin/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">
    @if($sec_css)
        <link rel="stylesheet" href="{{ asset('css/super-admin/' . $sec_css) }}">
    @endif

    <!-- Inter font CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Day.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.10/dayjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.10/locale/fr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.10/plugin/relativeTime.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>

    <!-- Avatars Random Coloration -->
    <script src="{{ asset('js/avatar-color-picker.js') }}" defer></script>

    <!-- Sidebar display -->
     <script src="{{ asset('js/hambuger.js') }}" defer></script>

    <!-- Select2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="main-sidebar"  id="main-sidebar">
            <div class="sidebar-header">
                <div class="logo-box">AS</div>
                <span class="brand-name">ArchiSearch</span>
                <button class="fermeraside">x</button>
            </div>

            <div class="nav-group">
                <div class="nav-label">Main</div>
                <a href="{{ route('super-admin.dashboard') }}"
                    class="nav-item {{ $active == 'supervision' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    Supervision
                </a>
                <a href="{{ route('super-admin.administrateurs') }}"
                    class="nav-item {{ $active == 'administrateurs' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Administrateurs
                </a>
                <a href="{{ route('super-admin.logs') }}" class="nav-item {{ $active == 'logs' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z" />
                        <path d="M12 2v20" />
                        <path d="M8 7h6" />
                        <path d="M8 11h6" />
                        <path d="M8 15h6" />
                    </svg>
                    Journaux système
                </a>
                <a href="{{ route('super-admin.students') }}" class="nav-item {{ $active == 'students' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
                        <path d="M22 12A10 10 0 0 0 12 2v10z" />
                    </svg>
                    Etudiants
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">Configuration</div>
                <a href="{{ route('super-admin.settings') }}"
                    class="nav-item {{ $active == 'parametres' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                    Paramètres globaux
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-item {{ $active == 'profil' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">

                        <path d="M20 21a8 8 0 0 0-16 0" />
                        <circle cx="12" cy="7" r="4" />

                    </svg>
                    Profil
                </a>
            </div>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                    @csrf
                </form>

                <a href="{{ route('logout') }}" class="nav-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    <span>Déconnexion</span>
                </a>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div style="flex: 1; display: flex; flex-direction: column;">
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
        </div>
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
    @if(session('danger'))
    <script>
        ASAlerts.danger(@json(session('danger')));
    </script>
    @endif
</body>

</html>