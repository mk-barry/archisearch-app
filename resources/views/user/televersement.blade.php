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
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; text-align: left;">
                    <div>
                        <h1 class="invitation-title" style="margin-bottom: 0.25rem;">Dépôt de documents</h1>
                        <p class="desc-text" style="margin-bottom: 0;">Bonjour <strong>Jean Dupont</strong> — 1/3 documents soumis</p>
                    </div>
                    <div class="badge-yellow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 4px; vertical-align: middle;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Expire dans 11j
                    </div>
                </div>

                <!-- Document List -->
                <div class="document-list" style="margin-bottom: 1.5rem;">
                    <!-- Success Card -->
                    <div class="upload-card success">
                        <div class="card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div class="card-info">
                            <div class="card-title">Pièce d'identité (recto/verso)</div>
                            <div class="card-sub">CNI_Dupont_2026.jpg · 1.8 Mo</div>
                        </div>
                        <div class="card-actions">
                            <div class="action-btn"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></div>
                            <div class="action-btn red"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></div>
                        </div>
                    </div>

                    <!-- Uploading Card -->
                    <div class="upload-card uploading">
                        <div class="card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M21 2v6h-6"/><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/></svg>
                        </div>
                        <div class="card-info">
                            <div class="card-title">Contrat de travail signé</div>
                            <div class="card-sub">
                                Contrat_signe.pdf · 2.3 Mo
                                <div class="progress-container" style="margin-left: 10px;">
                                    <div class="progress-fill"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State Card -->
                    <div class="upload-card empty">
                        <div class="card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        </div>
                        <div class="card-info">
                            <div class="card-title">Justificatif de domicile</div>
                            <div class="card-sub">Formats : PDF, JPG, PNG · Max 20 Mo</div>
                        </div>
                        <div class="card-actions">
                            <div class="action-btn" style="background: #2563eb; color: white; padding: 6px; border-radius: 6px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Global Drop Zone -->
                <div class="upload-zone-large">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m16 16-4-4-4 4"/></svg>
                    <div class="main-text">Glissez-déposez vos fichiers ici</div>
                    <div class="sub-text">ou cliquez pour sélectionner depuis votre appareil</div>
                </div>

                <!-- Final Action -->
                <button class="btn-start" onclick="window.location.href='#'" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    Soumettre tous les documents
                </button>
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.75rem;">Vous pourrez remplacer un fichier avant la clôture de l'événement.</p>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        © 2026 ArchiSearch · Plateforme de gestion documentaire
    </footer>
</body>
</html>
