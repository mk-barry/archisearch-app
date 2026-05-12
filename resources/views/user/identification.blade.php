<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identification - ArchiSearch</title>
    <link rel="stylesheet" href="{{ asset('css/user/invitation.css') }}">
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
        <div style="color: #94a3b8; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
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
                <!-- Stepper -->
                <div class="stepper">
                    <div class="step active">
                        <div class="step-num">1</div>
                        <div>Identification</div>
                        <div class="step-divider"></div>
                    </div>
                    <div class="step">
                        <div class="step-num">2</div>
                        <div>Téléversement</div>
                        <div class="step-divider"></div>
                    </div>
                    <div class="step">
                        <div class="step-num">3</div>
                        <div>Confirmation</div>
                    </div>
                </div>

                <div class="icon-box-large">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>

                <h1 class="invitation-title" style="margin-bottom: 0.5rem;">Identification</h1>
                <p class="desc-text" style="text-align: center; margin-bottom: 1.5rem;">
                    Veuillez renseigner vos informations avant de déposer vos documents. Aucune création de compte n'est
                    requise.
                </p>

                <!-- Context Box -->
                <div class="inline-context">
                    <div style="color: #2563eb;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <div style="font-size: 0.8rem;">
                        <div style="font-weight: 700; color: #1e293b;">{{ $event->title }}</div>
                        <div style="color: #64748b;">
                            {{ is_array($event->required_docs) ? count($event->required_docs) : 0 }} documents à
                            soumettre ·
                            Expire le {{ $event->end_date->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <!-- Form -->
                @if(session('error'))
                    <div
                        style="background: #fef2f2; color: #dc2626; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem; border: 1px solid #fee2e2;">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('invitation.verify', ['uuid' => $event->uuid]) }}" method="POST">
                @csrf
                <input type="hidden" name="event_uuid" value="{{ $event->uuid }}">
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="form-group">
                        <label class="form-label">Matricule / Identifiant Étudiant *</label>
                        <div class="input-with-icon">
                            <span class="input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                            </span>
                            <input type="text" name="identifier" class="form-input" placeholder="Ex : 22B567" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nom Complet *</label>
                        <input type="text" name="fullname" class="form-input" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0.5rem;">
                        <label class="form-label">Adresse e-mail (optionnel)</label>
                        <div class="input-with-icon">
                            <span class="input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </span>
                            <input type="email" class="form-input" placeholder="pour recevoir la confirmation">
                        </div>
                    </div>
                    <p class="form-help" style="text-align: left; margin-bottom: 2rem;">Si renseigné, vous recevrez
                        une
                        confirmation de dépôt.</p>

                        @php
$isClosed = ($event->status !== 'actif' || \Carbon\Carbon::now()->gt($event->end_date));
                        @endphp
                        
                        <button type="submit" class="btn-start">
                            @if($isClosed)
                                Consulter l'historique de téléversement
                            @else
                                Continuer vers le dépôt
                            @endif
                        </button>
                </form>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        © 2026 ArchiSearch · Plateforme de gestion documentaire
    </footer>
</body>

</html>