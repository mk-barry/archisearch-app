<x-auth-layout :hideHeader="true">
    <x-slot:title>ArchiSearch - Nouveau Mot de Passe</x-slot>
    <x-slot:breadcrumb_current>Changement de mot de passe</x-slot>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/password.css') }}">
    @endpush

    <main style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 1.5rem; min-height: calc(100vh - 80px);">
        <x-auth.card style="width: 550px; padding: 1.5rem 2.5rem;">
            <div class="warning-circle" style="margin-bottom: 0.5rem;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            </div>

            <h2 style="text-align: center; margin-bottom: 0.5rem; font-size: 1.5rem;">Changement de mot de passe requis</h2>
            <p class="subtitle" style="text-align: center; margin-bottom: 1.5rem; font-size: 0.9rem;">Pour des raisons de sécurité, vous devez définir un nouveau mot de passe lors de votre première connexion.</p>

            <form action="#" method="POST">
                @csrf
                <x-auth.input 
                    label="Mot de passe temporaire" 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    placeholder="••••••••" 
                    icon="lock" 
                    required 
                />

                <x-auth.input 
                    label="Nouveau mot de passe" 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="••••••••" 
                    icon="lock" 
                    required 
                    style="border-color: #2563eb; background-color: #eff6ff;"
                />

                <x-auth.input 
                    label="Confirmer le nouveau mot de passe" 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="••••••••" 
                    icon="lock" 
                    required 
                    class="input-success"
                />

                <div class="requirements-grid" style="margin-bottom: 1.25rem;">
                    <div class="requirement-item checked">
                        <svg class="requirement-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        <span>Min. 8 caractères</span>
                        <svg class="requirement-icon" style="margin-left:auto" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                    <div class="requirement-item checked">
                        <svg class="requirement-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        <span>Majuscule</span>
                        <svg class="requirement-icon" style="margin-left:auto" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                    <div class="requirement-item checked">
                        <svg class="requirement-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        <span>Chiffre</span>
                        <svg class="requirement-icon" style="margin-left:auto" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                    <div class="requirement-item checked">
                        <svg class="requirement-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        <span>Caractère spécial</span>
                        <svg class="requirement-icon" style="margin-left:auto" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                </div>

                <button type="submit" class="submit-btn" style="padding: 0.75rem;">Enregistrer et continuer</button>
            </form>
        </x-auth.card>
    </main>
</x-auth-layout>
