<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Historique - ArchiSearch</title>
    <link rel="stylesheet" href="{{ asset('css/user/invitation.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body style="background-color: #f8fafc;">
    <nav class="nav-simple">
        <div class="logo-brand">
            <div class="logo-square" style="background: #2563eb; color: white; padding: 5px 8px; border-radius: 6px;">AS
            </div>
            ArchiSearch
        </div>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="text-align: right;">
                <div style="font-weight: 700; font-size: 0.85rem; color: #1e293b;">{{ session('student_name') }}</div>
                <div style="font-size: 0.75rem; color: #64748b;">Matricule: {{ session('student_matricule') }}</div>
            </div>
            <a href="{{ route('invitation.logout', ['uuid' => 'all']) }}" style="color: #ef4444;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
                </svg>
            </a>
        </div>
    </nav>

    <div class="invitation-container" style="max-width: 800px; margin-top: 2rem;">
        <div class="page-header" style="margin-bottom: 2rem; text-align: left;">
            <h1 style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">Mes Dépôts Documentaires</h1>
            <p style="color: #64748b;">Retrouvez ici l'ensemble des événements auxquels vous avez participé.</p>
        </div>

        @forelse($events as $event)
            <div class="upload-card"
                style="margin-bottom: 1rem; cursor: default; display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: white; border: 1px solid #e2e8f0; border-radius: 12px;">
                <div style="display: flex; gap: 1.5rem; align-items: center;">
                    <div
                        style="width: 50px; height: 50px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #2563eb;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ $event->title }}</h3>
                        <div style="font-size: 0.8rem; color: #64748b; display: flex; gap: 12px;">
                            <span>Soumis le {{ $event->documents->first()->created_at->format('d/m/Y') }}</span>
                            <span>•</span>
                            <span style="color: #2563eb; font-weight: 600;">{{ $event->documents_count }} document(s)</span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    @if($event->status === 'actif')
                        <a href="{{ route('invitation.upload', $event->uuid) }}" class="btn-primary"
                            style="padding: 0.5rem 1rem; font-size: 0.8rem; text-decoration: none; border-radius: 8px;">
                            Gérer le dépôt
                        </a>
                    @else
                        <span
                            style="background: #f1f5f9; color: #64748b; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600;">Événement
                            Terminé</span>
                    @endif
                </div>
            </div>
        @empty
            <div
                style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 16px; border: 2px dashed #e2e8f0;">
                <div style="color: #cbd5e1; margin-bottom: 1rem;">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <path d="M14 2v6h6" />
                        <path d="M9 15h6" />
                        <path d="M9 11h6" />
                    </svg>
                </div>
                <p style="color: #64748b; font-weight: 500;">Aucun historique de dépôt trouvé pour votre matricule.</p>
            </div>
        @endforelse
    </div>

    <footer class="main-footer" style="margin-top: 4rem;">
        © 2026 ArchiSearch · Université - Service des Diplômes
    </footer>
</body>

</html>