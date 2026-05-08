@props(['active' => 'dashboard', 'title' => 'ArchiSearch - Admin Dashboard'])

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Select2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="main-sidebar">
            <div class="sidebar-header">
                <div class="logo-box"
                    style="background: #2563eb; color: white; padding: 6px 10px; border-radius: 6px; font-weight: bold;">
                    AS</div>
                <span class="brand-name" style="font-weight: 700; font-size: 1.2rem;">ArchiSearch</span>
            </div>

            <div class="nav-group">
                <div class="nav-label">Main</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ $active == 'dashboard' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    Tableau de bord
                </a>
                <a href="{{ route('admin.evenements') }}"
                    class="nav-item {{ $active == 'evenements' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                    </svg>
                    Événements
                </a>
                <a href="{{ route('admin.documents') }}" class="nav-item {{ $active == 'documents' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Documents
                </a>
                <a href="{{ route('admin.recherche') }}" class="nav-item {{ $active == 'recherche' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    Recherche
                </a>
                <a href="{{ route('admin.archives') }}" class="nav-item {{ $active == 'archives' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="21 8 21 21 3 21 3 8" />
                        <rect width="22" height="5" x="1" y="3" />
                        <line x1="10" x2="14" y1="12" y2="12" />
                    </svg>
                    Archives
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">Paramètres</div>
                <a href="{{ route('admin.cloud') }}" class="nav-item {{ $active == 'cloud' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M17.5 19A5.5 5.5 0 0 0 18 8.02a1 1 0 0 1-.89-.66 7 7 0 0 0-12.22 0 1 1 0 0 1-.89.66A5.5 5.5 0 0 0 4.5 19Z" />
                    </svg>
                    Sauvegarde Cloud
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-item {{ $active == 'profil' ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
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
            <!-- Top Nav -->
            <!-- <nav class="top-nav">
                <div class="breadcrumb" style="font-size: 0.9rem; color: #64748b;">
                    Portail Admin <svg style="display:inline-block; vertical-align:middle; margin: 0 4px;" width="14"
                        height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6" />
                    </svg> Tableau de bord
                </div>

                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div class="search-bar" style="position: relative; width: 280px;">
                        <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"
                            width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <input type="text" placeholder="Recherche rapide..."
                            style="width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; background: #f8fafc;">
                    </div>

                    <div style="position: relative;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b;">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <div
                            style="position: absolute; top: -2px; right: -2px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; border: 2px solid white;">
                        </div>
                    </div>

                    <div class="user-profile">
                        <div class="avatar">AM</div>
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-size: 0.9rem; font-weight: 700;">Admin Martin</span>
                            <span style="font-size: 0.75rem; color: #64748b;">Administrateur</span>
                        </div>
                    </div>
                </div>
            </nav> -->

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>