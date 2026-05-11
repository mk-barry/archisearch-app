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
                            {{ $event->documents->where('identifier', session('student_matricule'))->count() }}/{{ count($event->required_docs) }}
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
                    @foreach($event->required_docs as $docName)
                        @php
                            // On cherche si le document existe déjà pour cet étudiant et cet event
                            $uploadedFile = $event->documents
                                ->where('identifier', session('student_matricule'))
                                ->where('type_document', $docName)
                                ->first();
                        @endphp

                        @if($uploadedFile)
                            <div class="upload-card success">
                                <div class="card-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="3">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </div>
                                <div class="card-info">
                                    <div class="card-title">{{ $docName }}</div>
                                    <div class="card-sub">{{ $uploadedFile->original_name }} ·
                                        {{ round($uploadedFile->file_size / 1024, 2) }} Ko
                                    </div>
                                </div>
                                <div class="card-actions">
                                    <a href="{{ asset('storage/' . $uploadedFile->path) }}" target="_blank" class="action-btn">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('document.destroy', $uploadedFile->id) }}" method="POST"
                                        onsubmit="return confirm('Supprimer ce document ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn red">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="upload-card empty" onclick="triggerUpload('{{ $docName }}')">
                                <div class="card-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="17 8 12 3 7 8" />
                                        <line x1="12" x2="12" y1="3" y2="15" />
                                    </svg>
                                </div>
                                <div class="card-info">
                                    <div class="card-title">{{ $docName }}</div>
                                    <div class="card-sub">Format PDF, JPG ou PNG</div>
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
            <form id="uploadForm" action="{{ route('invitation.store.document', ['uuid' => $event->uuid]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="document_type" id="currentDocType">
                <input type="file" name="document" id="fileInput" style="display: none;" onchange="submitUpload()">
                @if($isClosed)
                    <div
                        style="text-align: center; background: #f8fafc; padding: 2rem; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        <p style="color: #64748b; margin-bottom: 1.5rem;">Cet événement est clôturé. Vous pouvez consulter
                            vos dépôts dans votre historique.</p>
                        <a href="{{ route('invitation.history') }}" class="btn-primary"
                            style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Voir mes événements
                        </a>
                    </div>
                @else
                    <a href="{{ route('invitation.confirmation', ['uuid' => $event->uuid]) }}" class="btn-start"
                        style="text-decoration: none; text-align: center; display: block;">
                        Terminer et voir la confirmation
                    </a>
                @endif
            </form>


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
        function triggerUpload(docType) {
            document.getElementById('currentDocType').value = docType;
            document.getElementById('fileInput').click();
        }

        function submitUpload() {
            const form = document.getElementById('uploadForm');
            const formData = new FormData(form);
            const docType = document.getElementById('currentDocType').value;

            // Optionnel : Afficher un loader ici
            console.log("Upload en cours pour : " + docType);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
                .then(response => {
                    if (response.ok) {
                        // Recharger la page ou mettre à jour la carte en JS
                        window.location.reload();
                    } else {
                        alert("Erreur lors du téléversement");
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }
    </script>
</body>

</html>