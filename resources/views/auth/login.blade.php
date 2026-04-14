{{-- ============================================================
     ArchiSearch — Auth / Login Page
     View:   resources/views/auth/login.blade.php
     CSS:    public/css/auth/login.css
     ============================================================ --}}
<x-auth-layout>
    <x-slot:title>ArchiSearch — Connexion</x-slot:title>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    @endpush

    <div class="auth-page">

        {{-- ── Brand bar ── --}}
        <div class="auth-brand">
            <div class="auth-brand__logo" aria-hidden="true">AS</div>
            <span class="auth-brand__name">ArchiSearch</span>
        </div>

        {{-- ── Main split layout ── --}}
        <main class="auth-main">

            {{-- ── Hero (left) ── --}}
            <section class="auth-hero" aria-label="Présentation">
                <h1 class="auth-hero__title">
                    Gestion<br>documentaire<br>
                    <span class="accent">intelligente</span>
                </h1>
                <p class="auth-hero__desc">
                    Lorem ipsum dolor sit amet consectetur adipiscing elit.
                    Archivez, indexez et retrouvez vos documents en quelques secondes.
                </p>

                <div class="auth-hero__stats" role="list">
                    <div class="stat-card" role="listitem">
                        <span class="stat-card__value">12 K+</span>
                        <span class="stat-card__label">Documents archivés</span>
                    </div>
                    <div class="stat-card" role="listitem">
                        <span class="stat-card__value">99%</span>
                        <span class="stat-card__label">Disponibilité</span>
                    </div>
                    <div class="stat-card" role="listitem">
                        <span class="stat-card__value">&lt;&nbsp;2s</span>
                        <span class="stat-card__label">Recherche</span>
                    </div>
                </div>
            </section>

            {{-- ── Login card (right) ── --}}
            <x-auth.card>
                <h2 class="auth-card__title">Connexion</h2>
                <p class="auth-card__subtitle">Accédez à votre espace d'administration</p>

                {{-- Session errors --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form action="{{ route('login') }}" method="POST" novalidate>
                    @csrf

                    {{-- Email --}}
                    <x-auth.input
                        label="Adresse e-mail"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="admin@exemple.gouv"
                        icon="email"
                        :value="old('email')"
                        required
                        autocomplete="email"
                    />
                    <x-input-error :messages="$errors->get('email')" />

                    {{-- Password --}}
                    <x-auth.input
                        label="Mot de passe"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        icon="lock"
                        forgotLink="{{ route('password.request') }}"
                        required
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('password')" />

                    {{-- Remember me --}}
                    <div class="form-options">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Se souvenir de moi sur cet appareil</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="submit-btn" id="login-submit">
                        Se connecter
                    </button>

                    {{-- Security notice --}}
                    <div class="security-info">
                        <svg class="security-info__icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/>
                        </svg>
                        <span>Session chiffrée HTTPS · Expiration automatique après 30 min d'inactivité</span>
                    </div>
                </form>
            </x-auth.card>

        </main>

        {{-- ── Footer ── --}}
        <footer class="auth-footer" role="contentinfo">
            <p class="auth-footer__text">© 2026 ArchiSearch — Innovative Clan · Tous droits réservés</p>
        </footer>

    </div>{{-- .auth-page --}}
</x-auth-layout>
