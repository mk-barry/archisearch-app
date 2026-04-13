<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation à soumettre vos documents - ArchiSearch</title>
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
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Connexion sécurisée
        </div>
    </nav>

    <div class="invitation-container">
        <div class="invitation-header">
            <div class="header-accent"></div>
            <div class="card-body">
                <div class="icon-box-large">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>

                <span class="badge-label">Invitation à soumettre vos documents</span>
                <h1 class="invitation-title">Collecte Contrats RH — Avr 2026</h1>

                <div class="description-box">
                    <p class="desc-text">
                        Lorem ipsum dolor sit amet consectetur adipiscing elit. 
                        L'administration vous invite à soumettre les documents listés ci-dessous avant la date limite indiquée.
                    </p>
                    <div class="meta-row">
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            Date limite : <strong>15 Avr 2026</strong>
                        </div>
                        <div class="meta-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <strong>3 documents</strong> à soumettre
                        </div>
                    </div>
                </div>

                <div class="checklist-section">
                    <h2 class="checklist-title">Documents à fournir :</h2>
                    
                    <div class="checklist-item">
                        <div class="number-badge">1</div>
                        <div class="item-name">Pièce d'identité (recto/verso)</div>
                        <div class="item-format">PDF, JPG, PNG · max 20 Mo</div>
                    </div>

                    <div class="checklist-item">
                        <div class="number-badge">2</div>
                        <div class="item-name">Contrat de travail signé</div>
                        <div class="item-format">PDF, JPG, PNG · max 20 Mo</div>
                    </div>

                    <div class="checklist-item">
                        <div class="number-badge">3</div>
                        <div class="item-name">Justificatif de domicile</div>
                        <div class="item-format">PDF, JPG, PNG · max 20 Mo</div>
                    </div>
                </div>

                <button class="btn-start" onclick="window.location.href='{{ route('invitation.identification') }}'">
                    Commencer la soumission
                </button>

                <div class="security-footer">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Lien sécurisé · Valide jusqu'au 15 Avr 2026
                </div>
            </div>
        </div>

        <div class="alert-warning">
            <div class="warning-icon">!</div>
            <div>
                Ce lien est personnel et à usage unique. Ne le partagez pas avec des tiers. 
                Il expirera automatiquement à la date limite ou à la clôture de l'événement.
            </div>
        </div>
    </div>

    <footer class="main-footer">
        © 2026 ArchiSearch · Plateforme de gestion documentaire
    </footer>
</body>
</html>
