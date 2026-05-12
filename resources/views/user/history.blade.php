<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Historique - ArchiSearch</title>
    <link rel="stylesheet" href="{{ asset('css/user/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/history.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="nav-simple">
        <div class="logo-brand">
            <div class="logo-square">AS</div>
            ArchiSearch
        </div>
        <div class="nav-profile-area">
            <div class="profile-text">
                <div class="profile-name">{{ session('student_name') }}</div>
                <div class="profile-matricule">Matricule: {{ session('student_matricule') }}</div>
            </div>
            <a href="{{ route('invitation.logout', ['uuid' => 'all']) }}" class="logout-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
                </svg>
            </a>
        </div>
    </nav>

    <div class="invitation-container large">
        <div class="history-header">
            <h1 class="history-title">Mes Dépôts Documentaires</h1>
            <p class="history-subtitle">Retrouvez ici l'ensemble des événements auxquels vous avez participé.</p>
        </div>

        @forelse($events as $event)
            <div class="history-card">
                <div class="history-card-info">
                    <div class="history-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="history-event-title">{{ $event->title }}</h3>
                        <div class="history-meta">
                            <span>Soumis le {{ $event->documents->first()->created_at->format('d/m/Y') }}</span>
                            <span>•</span>
                            <span class="history-doc-count">{{ $event->documents_count }} document(s)</span>
                        </div>
                    </div>
                </div>

                <div class="history-card-actions">
                    @if($event->status === 'actif')
                        <a href="{{ route('invitation.upload', $event->uuid) }}" class="btn-manage">
                            Gérer le dépôt
                        </a>
                    @else
                        <span class="status-ended">Événement Terminé</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="history-empty">
                <div class="empty-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <path d="M14 2v6h6" />
                        <path d="M9 15h6" />
                        <path d="M9 11h6" />
                    </svg>
                </div>
                <p class="empty-text">Aucun historique de dépôt trouvé pour votre matricule.</p>
            </div>
        @endforelse
    </div>

    <footer class="main-footer footer-margin">
        © 2026 ArchiSearch · Université - Service des Diplômes
    </footer>
</body>

</html>