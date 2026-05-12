<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents soumis avec succès - ArchiSearch</title>
    <link rel="stylesheet" href="{{ asset('css/user/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/confirmation.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="nav-simple">
        <div class="logo-brand">
            <div class="logo-square">AS</div>
            ArchiSearch
        </div>
        <div class="nav-secure-text">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
            Connexion sécurisée
        </div>
    </nav>

    <div class="invitation-container">
        <div class="invitation-header">
            <div class="header-accent success-accent"></div>
            <div class="card-body">
                <div class="stepper">
                    <div class="step finished">
                        <div class="step-num">✓</div>
                        <div>Identification</div>
                        <div class="step-divider"></div>
                    </div>
                    <div class="step finished">
                        <div class="step-num">✓</div>
                        <div>Téléversement</div>
                        <div class="step-divider"></div>
                    </div>
                    <div class="step active finished">
                        <div class="step-num">✓</div>
                        <div>Confirmation</div>
                    </div>
                </div>

                <div class="icon-box-large success-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>

                <h1 class="invitation-title">Documents soumis avec succès !</h1>
                <p class="desc-text">
                    Merci <strong>{{ session('student_name') }}</strong>. Vos documents ont bien été reçus.
                </p>

                <div>
                    <h2 class="checklist-title muted">
                        Statut de vos documents ({{ $documents->count() }}) :
                    </h2>

                    @foreach($documents as $doc)
                        <div class="doc-info-bar">
                            <div class="ext-badge ext-{{ strtolower($doc->file_type) }}">
                                {{ strtoupper($doc->file_type) }}
                            </div>

                            <div class="doc-name">
                                {{ $doc->category }}
                            </div>

                            <div class="status-badge {{ $doc->status }}">
                                @if($doc->status == 'submitted') Soumis
                                @elseif($doc->status == 'pending') En cours
                                @elseif($doc->status == 'validated') Accepté
                                @elseif($doc->status == 'rejected') Rejeté
                                @else {{ $doc->status }} @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(session('student_email'))
                    <div class="info-alert-blue">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="16" y2="12" />
                            <line x1="12" x2="12" y1="8" y2="8" />
                        </svg>
                        <div>
                            Un e-mail de confirmation a été envoyé à
                            <strong>{{ Str::mask(session('student_email'), '*', 1, 8) }}</strong>.
                        </div>
                    </div>
                @endif

                <div class="confirmation-actions">
                    <div class="event-closed-meta">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                        </svg>
                        Événement clôturé le <strong>{{ $event->end_date->format('d M Y') }}</strong>
                    </div>
                    <a href="{{ route('invitation.upload', $event->uuid) }}" class="action-link">
                        Ajouter un fichier
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                    <a href="#" class="action-link primary">
                        Remplacer un fichier
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                </div>
            </div>

            <p class="desc-text" style="margin-top: 2rem;">
                Vous pouvez fermer cette fenêtre en toute sécurité.
            </p>
        </div>
    </div>

    <footer class="main-footer">
        © 2026 ArchiSearch · Plateforme de gestion documentaire
    </footer>
</body>

</html>