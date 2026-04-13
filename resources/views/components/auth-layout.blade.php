@props(['hideHeader' => false])

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ArchiSearch' }}</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    @stack('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">
    @if(!$hideHeader)
    <header>
        <div class="logo-container">
            <div class="logo-box">AS</div>
            <span class="brand-name">ArchiSearch</span>
        </div>
        <div class="breadcrumbs">
            <span>{{ $breadcrumb_parent ?? 'Authentification' }}</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            <span style="color: white; font-weight: 500;">{{ $breadcrumb_current }}</span>
        </div>
    </header>
    @endif

    {{ $slot }}

    <footer>
        <div class="footer-text">
            © 2026 ArchiSearch — Innovative Clan — Tous droits réservés
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
