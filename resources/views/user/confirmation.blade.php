<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents soumis avec succès - ArchiSearch</title>
    <link rel="stylesheet" href="{{ asset('css/user/invitation.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="nav-simple">
        <div class="logo-brand">
            <div class="logo-square" style="background: #2563eb; color: white; padding: 5px 8px; border-radius: 6px;">AS</div>
            ArchiSearch
        </div>
        <div style="color: #94a3b8; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Connexion sécurisée
        </div>
    </nav>

    <div class="invitation-container" style="max-width: 520px;">
        <div class="invitation-header">
            <div class="header-accent success-accent"></div>
            <div class="card-body">
                <!-- Stepper -->
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
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                </div>

                <h1 class="invitation-title" style="margin-bottom: 0.5rem;">Documents soumis avec succès !</h1>
                <p class="desc-text" style="text-align: center; margin-bottom: 2rem;">
                    Merci <strong>{{ session('student_name') }}</strong>. Vos documents ont bien été reçus.
                </p>
                
                <div style="text-align: left; margin-bottom: 1.5rem;">
                    <h2 class="checklist-title" style="font-size: 0.9rem; margin-bottom: 1rem; color: #64748b;">
                        Statut de vos documents ({{ $documents->count() }}) :
                    </h2>
                
                    @foreach($documents as $doc)
                        <div class="doc-info-bar"
                            style="display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 10px; border-radius: 8px; margin-bottom: 8px;">
                            {{-- Badge Extension Dynamique --}}
                            <div class="ext-badge ext-{{ strtolower($doc->file_type) }}"
                                style="padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 800; background: #e2e8f0;">
                                {{ strtoupper($doc->file_type) }}
                            </div>

                            <div
                                style="flex: 1; font-weight: 600; font-size: 0.85rem; color: #1e293b; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $doc->category }} {{-- Affiche "CNI", "Contrat", etc. --}}
                            </div>

                            {{-- Badge Statut Dynamique --}}
                            <div class="status-badge {{ $doc->status }}"
                                style="font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 600;">
                                @if($doc->status == 'submitted') Soumis
                                @elseif($doc->status == 'pending') En cours
                                @elseif($doc->status == 'validated') Accepté
                                @else {{ $doc->status }} @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if(session('student_email'))
                    <div class="info-alert-blue">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="16" y2="12" />
                            <line x1="12" x2="12" y1="8" y2="8" />
                        </svg>
                        <div>
                            Un e-mail de confirmation a été envoyé à <strong>{{ Str::mask(session('student_email'), '*', 1, 8) }}</strong>.
                        </div>
                    </div>
                @endif
                
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; font-size: 0.8rem; color: #94a3b8;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                        </svg>
                        Événement clôturé le <strong>{{ $event->end_date->format('d M Y') }}</strong>
                    </div>
                    <a href="{{ route('invitation.upload', $event->uuid) }}"
                        style="color: #2563eb; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                        Ajouter un fichier
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                </div>                    
                <a href="#" style="color: #2563eb; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                        Remplacer un fichier
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>

                <p style="margin-top: 2rem; font-size: 0.75rem; color: #94a3b8;">Vous pouvez fermer cette fenêtre en toute sécurité.</p>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        © 2026 ArchiSearch · Plateforme de gestion documentaire
    </footer>
</body>
</html>
