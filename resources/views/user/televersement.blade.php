<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléversement des documents - ArchiSearch</title>
    <link rel="stylesheet" href="{{ asset('css/user/invitation.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="nav-simple">
        <div class="logo-brand">
            <div class="logo-square" style="background: #2563eb; color: white; padding: 5px 8px; border-radius: 6px;">AS
            </div>
            ArchiSearch
        </div>
        <div style="color: #94a3b8; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
            Connexion sécurisée
        </div>
    </nav>

    <div class="invitation-container" style="max-width: 520px;">
        <div class="invitation-header" style="display: flex; flex-direction: column; align-items: center;">
            <div class="header-accent"></div>
            <div class="card-body">
                <!-- Stepper -->
                <div class="stepper">
                    <div class="step finished">
                        <div class="step-num">✓</div>
                        <div>Identification</div>
                        <div class="step-divider"></div>
                    </div>
                    <div class="step active">
                        <div class="step-num">2</div>
                        <div>Téléversement</div>
                        <div class="step-divider" style="background: #e2e8f0;"></div>
                    </div>
                    <div class="step">
                        <div class="step-num">3</div>
                        <div>Confirmation</div>
                    </div>
                </div>

                <!-- Page Header with Badge -->
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; text-align: left;">
                    <div>
                        <h1 class="invitation-title" style="margin-bottom: 0.25rem;">Dépôt de documents</h1>
                        <p class="desc-text" style="margin-bottom: 0;">
                            Bonjour <strong>{{ session('student_name') }}</strong> —
                            {{ $event->documents->where('identifier', session('student_matricule'))->count() }} / {{ $event->documentTypes->count() }}
                            documents soumis
                        </p>
                    </div>
                    @php
// On calcule la différence entre maintenant et la date de fin
$now = now();
$daysRemaining = $now->diffInDays($event->end_date, false);
                    @endphp
                    @if($event->status === 'cloturé' || $now->gt($event->end_date))
                        <div class="badge-red"
                            style="background: #fef2f2; color: #dc2626; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 4px;">
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
                                    stroke-width="2.5" style="margin-right: 4px; vertical-align: middle;">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                Expire dans {{ ceil($daysRemaining) }}j
                            </div>
                        @else
                            <div class="badge-red"
                                style="background: #fef2f2; color: #dc2626; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                Terminé
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Document List -->
                <div class="document-list" style="margin-bottom: 1.5rem;">
                    @foreach($event->documentTypes as $type) {{-- Utilise la relation documentTypes --}}
                        @php
    $uploadedFile = $submissions->where('category', $type->label)->first();
    // Récupération des extensions depuis la BD (ex: ["pdf", "jpg"])
    $extensions = is_array($type->allowed_extensions)
        ? implode(', ', array_map('strtoupper', $type->allowed_extensions))
        : 'PDF, JPG, PNG';
                        @endphp

                        @if($uploadedFile)
                        @else
                            {{-- On passe l'ID du type de document à la fonction JS --}}
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
                                    {{-- Statistiques dynamiques --}}
                                    <div class="card-sub">Formats : {{ $extensions }} · Max
                                        {{ round(($type->max_size_kb ?? 2048) / 1024) }} Mo
                                    </div>
                                </div>
                                <div class="card-actions">
                                    <div class="action-btn" style="background: #2563eb; color: white;">
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
            </div>

            <!-- Global Drop Zone -->
            <div class="upload-zone-large" style="width: 80%; cursor: pointer;" onclick="triggerUpload('Generique')">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242" />
                    <path d="M12 12v9" />
                    <path d="m16 16-4-4-4 4" />
                </svg>
                <div class="main-text">Glissez-déposez vos fichiers ici</div>
                <div class="sub-text">ou cliquez pour sélectionner depuis votre appareil</div>
            </div>
            <!-- Final Action -->
            <form id="uploadForm" action="{{ route('invitation.store.document', ['uuid' => $event->uuid]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="document_type_id" id="currentDocType"> {{-- ID injecté ici --}}
                <input type="file" name="document" id="fileInput" style="display: none;" onchange="submitUpload()">
            </form>
            @if($isClosed)
                <div
                    style="text-align: center; background: #f8fafc; padding: 2rem; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <p style="color: #64748b; margin-bottom: 1.5rem;">Cet événement est clôturé. Vous pouvez consulter
                        vos dépôts dans votre historique.</p>
                    <a href="{{ route('invitation.history') }}" class="btn-start"
                        style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; width: 60%;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Voir mes événements
                    </a>
                </div>
            @else
                    <a href="{{ route('invitation.confirmation', ['uuid' => $event->uuid]) }}" class="btn-start"
                        style="text-decoration: none; text-align: center; display: block; width: 60%;">
                        Terminer et voir la confirmation
                    </a>
                @endif


            <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.75rem 0; text-align: center;">Vous pourrez remplacer
                un fichier
                avant la clôture de l'événement.</p>
        </div>
    </div>
    </div>

    <footer class="main-footer">
        © 2026 ArchiSearch · Plateforme de gestion documentaire
    </footer>
    <script>
        function triggerUpload(typeId, extensions) {
            // On met l'ID du type de document dans le champ caché
            document.getElementById('currentDocType').value = typeId;

            // Optionnel : On peut restreindre les fichiers dans la fenêtre de sélection
            if (extensions) {
                const accept = extensions.split(', ').map(ext => '.' + ext.toLowerCase()).join(',');
                document.getElementById('fileInput').setAttribute('accept', accept);
            }

            document.getElementById('fileInput').click();
        }

        function submitUpload() {
            const form = document.getElementById('uploadForm');
            const formData = new FormData(form);

            // On récupère l'ID qu'on a stocké juste avant
            const typeId = document.getElementById('currentDocType').value;
            formData.append('document_type_id', typeId);

            // Loader visuel (optionnel mais recommandé)
            console.log("Envoi du document type ID: " + typeId);

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
                        window.location.reload();
                    } else {
                        alert(data.message || "Erreur lors du téléversement");
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Une erreur est survenue lors de la connexion au serveur.");
                });
        }
    </script>
</body>

</html>