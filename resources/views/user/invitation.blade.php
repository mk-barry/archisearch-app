<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - ArchiSearch</title>
    <link rel="stylesheet" href="{{ asset('css/user/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/invitation.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
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

    @php
use Carbon\Carbon;
$deadline = Carbon::parse($event->end_date)->locale('fr')->isoFormat('LL');
$maxSizeMo = $event->max_file_size ? round($event->max_file_size / 1024) : 2;
    @endphp

    <div class="invitation-container">
        <div class="invitation-header">
            <div class="header-accent"></div>
            <div class="card-body">
                <div class="icon-box-large">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                </div>

                <span class="badge-label">Dépôt de documents officiel</span>
                <h1 class="invitation-title">{{ $event->title }}</h1>

                <div class="description-box">
                    <p class="desc-text">
                        {{ $event->description ?? "Veuillez soumettre les pièces justificatives requises pour cet événement académique." }}
                    </p>

                    <div class="meta-row">
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                                <line x1="16" x2="16" y1="2" y2="6" />
                                <line x1="8" x2="8" y1="2" y2="6" />
                                <line x1="3" x2="21" y1="10" y2="10" />
                            </svg>
                            Clôture : <strong>{{ $deadline }}</strong>
                        </div>
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                            </svg>
                            <strong>{{ $event->documentTypes->count() }} pièce(s)</strong> demandée(s)
                        </div>
                    </div>
                </div>

                <div class="checklist-section">
                    <h2 class="checklist-title">Liste des documents à préparer :</h2>

                    @forelse($event->documentTypes as $index => $type)
                        @php
    $docMaxSizeKb = $type->max_size_kb ?? 2048;
    $docMaxSizeMo = round($docMaxSizeKb / 1024, 1);
                        @endphp
                        <div class="checklist-item">
                            <div class="number-badge">{{ $index + 1 }}</div>
                            <div class="item-name">{{ $type->label }}</div>
                            <div class="item-format">Format PDF recommandé · Max {{ $maxSizeMo }} Mo</div>
                        </div>
                    @empty
                        <p class="empty-checklist">Aucun document spécifique n'est requis pour cet événement.</p>
                    @endforelse
                </div>

                <button class="btn-start"
                    onclick="window.location.href='{{ route('invitation.identification', ['uuid' => $event->uuid]) }}'">
                    Commencer l'identification
                </button>

                <div class="security-footer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Certifié conforme par le système ArchiSearch
                </div>
            </div>
        </div>

        <div class="alert-warning">
            <div class="warning-icon">!</div>
            <div>
                <strong>Important :</strong> Assurez-vous que vos scans sont lisibles.
                Une fois soumis, vos documents seront archivés et certifiés numériquement.
            </div>
        </div>
    </div>

    <footer class="main-footer">
        © 2026 ArchiSearch · Université - Service des Diplômes
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                ASAlerts.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                ASAlerts.error("Oups !", "{{ session('error') }}");
            @endif

            @if(session('info'))
                ASAlerts.info("Note", "{{ session('info') }}");
            @endif
        });
    </script>
</body>

</html>