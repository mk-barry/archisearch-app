{{-- ============================================================
     ArchiSearch — Auth Layout Component
     Usage: <x-auth-layout :page="'login'" />
     ============================================================ --}}
@props(['page' => 'login'])

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ArchiSearch — Plateforme de gestion documentaire intelligente">
    <title>{{ $title ?? 'ArchiSearch' }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Page-specific CSS loaded by each view --}}
    @stack('styles')
</head>
<body>
    {{ $slot }}
</body>
</html>
