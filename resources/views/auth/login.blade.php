<x-auth-layout :hideHeader="true">
    <x-slot:title>ArchiSearch - Connexion</x-slot>
    <x-slot:breadcrumb_current>Connexion</x-slot>

    <main style="padding-top: 4rem;">
        <section class="hero-section">
            <div class="logo-container" style="margin-bottom: 3rem;">
                <div class="logo-box" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(5px);">AS</div>
                <span class="brand-name" style="font-size: 1.5rem;">ArchiSearch</span>
            </div>
            <h1>Gestion documentaire intelligente</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipiscing elit. Archivez, indexez et retrouvez vos documents en quelques secondes.</p>
            
            <div class="stats-container">
                <div class="stat-card">
                    <span class="stat-value">12 K+</span>
                    <span class="stat-label">Documents archivés</span>
                </div>
                <div class="stat-card">
                    <span class="stat-value">99%</span>
                    <span class="stat-label">Disponibilité</span>
                </div>
                <div class="stat-card">
                    <span class="stat-value">&lt; 2s</span>
                    <span class="stat-label">Recherche</span>
                </div>
            </div>
        </section>

        <x-auth.card>
            <h2>Connexion</h2>
            <p class="subtitle">Accédez à votre espace d'administration</p>

            <form action="#" method="POST">
                @csrf
                <x-auth.input 
                    label="Adresse e-mail" 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="admin@exemple.gouv" 
                    icon="email" 
                    required 
                />

                <x-auth.input 
                    label="Mot de passe" 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="••••••••" 
                    icon="lock" 
                    required 
                />

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Se souvenir de moi sur cet appareil</span>
                    </label>
                </div>

                <button type="submit" class="submit-btn" style="margin-top: 1rem;">Se connecter</button>

                <div class="security-info">
                    <svg class="security-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
                    <span>Session chiffrée HTTPS - Expiration automatique après 30 min d'inactivité</span>
                </div>
            </form>
        </x-auth.card>
    </main>
</x-auth-layout>
</html>
