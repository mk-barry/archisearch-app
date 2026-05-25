<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléversement des documents - ArchiSearch</title>
    <link rel="stylesheet" href="{{ asset('css/user/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/televersement.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
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
            <div class="header-accent"></div>
            <div class="card-body">
                <div class="stepper">
                    <div class="step finished">
                        <div class="step-num">✓</div>
                        <div>Identification</div>
                        <div class="step-divider"></div>
                    </div>
                    <div class="step active">
                        <div class="step-num">2</div>
                        <div>Téléversement</div>
                        <div class="step-divider"></div>
                    </div>
                    <div class="step">
                        <div class="step-num">3</div>
                        <div>Confirmation</div>
                    </div>
                </div>

                <div class="televersement-header">
                    <div>
                        <h1 class="invitation-title">Dépôt de documents</h1>
                        <p class="desc-text">
                            Bonjour <strong>{{ session('student_name') }}</strong> —
                            {{ $event->documents->where('identifier', session('student_matricule'))->count() }} /
                            {{ $event->documentTypes->count() }} documents soumis
                        </p>
                    </div>
                    @php
                        $now = now();
                        $daysRemaining = $now->diffInDays($event->end_date, false);
                    @endphp
                    @if($event->status === 'cloturé' || $now->gt($event->end_date))
                        <div class="badge-red">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                            Clôturé
                        </div>
                    @else
                        @if($daysRemaining > 0)
                            <div class="badge-yellow">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                Expire dans {{ ceil($daysRemaining) }}j
                            </div>
                        @else
                            <div class="badge-red">
                                Terminé
                            </div>
                        @endif
                    @endif
                </div>

                <div class="document-list">
                    @foreach($event->documentTypes as $type)
                        @php
                            $uploadedFile = $submissions->where('category', $type->label)->first();
                            $extensions = is_array($type->allowed_extensions) ? implode(', ', array_map('strtoupper', $type->allowed_extensions)) : 'PDF, JPG, PNG';
                        @endphp

                        @if($uploadedFile)
                        @else
                            <div class="upload-card empty" onclick="triggerUpload({{ $type->id }}, '{{ $extensions }}')">
                                <div class="card-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="17 8 12 3 7 8" />
                                        <line x1="12" x2="12" y1="3" y2="15" />
                                    </svg>
                                </div>
                                <div class="card-info">
                                    <div class="card-title">{{ $type->label }}</div>
                                    <div class="card-sub">Formats : {{ $extensions }} · Max
                                        {{ round(($type->max_size_kb ?? 2048) / 1024) }} Mo</div>
                                </div>
                                <div class="card-actions">
                                    <div class="action-btn-blue">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="3">
                                            <path d="M12 5v14M5 12h14" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="upload-zone-large" onclick="triggerUpload('Generique')">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242" />
                        <path d="M12 12v9" />
                        <path d="m16 16-4-4-4 4" />
                    </svg>
                    <div class="main-text">Glissez-déposez vos fichiers ici</div>
                    <div class="sub-text">ou cliquez pour sélectionner depuis votre appareil</div>
                </div>

                <form id="uploadForm" action="{{ route('invitation.store.document', ['uuid' => $event->uuid]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <input type="hidden" name="document_type_id" id="currentDocType">
                    <input type="file" name="document" id="fileInput" style="display: none;" onchange="submitUpload()">
                </form>

                @if($isClosed)
                    <div class="closed-state-box">
                        <p class="closed-state-text">Cet événement est clôturé. Vous pouvez consulter vos dépôts dans votre
                            historique.</p>
                        <a href="{{ route('invitation.history') }}" class="btn-start centered-action">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Voir mes événements
                        </a>
                    </div>
                @else
                    <a href="{{ route('invitation.confirmation', ['uuid' => $event->uuid]) }}"
                        class="btn-start centered-action">
                        Terminer et voir la confirmation
                    </a>
                @endif

                <p class="footer-hint">Vous pourrez remplacer un fichier avant la clôture de l'événement.</p>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        © 2026 ArchiSearch · Plateforme de gestion documentaire
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
    <script>
        function triggerUpload(typeId, extensions) {
            document.getElementById('currentDocType').value = typeId;
            if (extensions) {
                const accept = extensions.split(', ').map(ext => '.' + ext.toLowerCase()).join(',');
                document.getElementById('fileInput').setAttribute('accept', accept);
            }
            document.getElementById('fileInput').click();
        }

        function submitUpload() {
                const form = document.getElementById('uploadForm');
                const formData = new FormData(form);
                const typeId = document.getElementById('currentDocType').value;

                // 1. Afficher le loader pendant le traitement
                ASAlerts.showLoading("Téléversement et indexation de votre document...");

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // 2. Notification de succès rapide avant de recharger
                            ASAlerts.success(data.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000); // On laisse 1 seconde pour voir le succès
                        } else {
                            // 3. Alerte d'erreur propre
                            ASAlerts.error("Erreur de dépôt", data.message || "Le fichier n'a pas pu être envoyé.");
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        ASAlerts.error("Connexion perdue", "Impossible de joindre le serveur. Vérifiez votre connexion internet.");
                    });
            }
    </script>
</body>

</html>