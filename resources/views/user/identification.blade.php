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
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
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
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>

                <h1 class="invitation-title" style="margin-bottom: 0.5rem;">Identification</h1>
                <p class="desc-text" style="text-align: center; margin-bottom: 1.5rem;">
                    Veuillez renseigner vos informations avant de déposer vos documents. Aucune création de compte n'est requise.
                </p>

                <!-- Context Box -->
                <div class="inline-context">
                    <div style="color: #2563eb;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div style="font-size: 0.8rem;">
                        <div style="font-weight: 700; color: #1e293b;">Collecte Contrats RH — Avr 2026</div>
                        <div style="color: #64748b;">3 documents à soumettre · Expire le 15 Avr 2026</div>
                    </div>
                </div>

                <!-- Form -->
                <form action="#" method="GET">
                    <div class="form-group">
                        <label class="form-label">Prénom *</label>
                        <div class="input-with-icon">
                            <span class="input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                            <input type="text" class="form-input" placeholder="Ex : Jean" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nom *</label>
                        <div class="input-with-icon">
                            <span class="input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                            <input type="text" class="form-input" placeholder="Ex : Dupont" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0.5rem;">
                        <label class="form-label">Adresse e-mail (optionnel)</label>
                        <div class="input-with-icon">
                            <span class="input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </span>
                            <input type="email" class="form-input" placeholder="pour recevoir la confirmation">
                        </div>
                    </div>
                    <p class="form-help" style="text-align: left; margin-bottom: 2rem;">Si renseigné, vous recevrez une confirmation de dépôt.</p>

                    <button type="submit" class="btn-start" style="margin-bottom: 0;">
                        Continuer vers le dépôt
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
