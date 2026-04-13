<x-auth-layout :hideHeader="true">
    <x-slot:title>Vérification 2FA - ArchiSearch</x-slot>
    <x-slot:breadcrumb_current>Vérification 2FA</x-slot>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/two-factor.css') }}">
    @endpush

    <main style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 1.5rem;">
        <x-auth.card style="width: 500px; text-align: center; padding: 2rem 2.5rem;">
            <div class="shield-icon-wrapper" style="margin-bottom: 0.5rem;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
            </div>
            
            <h2 style="margin-bottom: 0.5rem; font-size: 1.5rem;">Vérification en deux étapes</h2>
            <p class="subtitle" style="margin-bottom: 1.5rem;">Un code OTP à 6 chiffres a été envoyé à<br><strong style="color: #1e293b;">a***n@exemple.gouv</strong></p>

            <form action="#" method="POST">
                @csrf
                <div class="otp-container">
                    <input type="text" class="otp-box filled" maxlength="1" value="4">
                    <input type="text" class="otp-box filled" maxlength="1" value="7">
                    <input type="text" class="otp-box filled" maxlength="1" value="2">
                    <input type="text" class="otp-box" maxlength="1" placeholder="•">
                    <input type="text" class="otp-box" maxlength="1" placeholder="•">
                    <input type="text" class="otp-box" maxlength="1" placeholder="•">
                </div>

                <div class="resend-text">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M3 21v-5h5"/></svg>
                    <span>Renvoyer le code dans <span class="resend-timer">02:34</span></span>
                </div>

                <button type="submit" class="submit-btn" style="margin-top: 1rem;">Vérifier le code</button>

                <div class="alert-info">
                    <svg class="alert-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    <span>Connexion détectée depuis un nouvel appareil. Confirmez votre identité pour continuer.</span>
                </div>

                <a href="{{ route('login') }}" class="back-to-login">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    Retour à la connexion
                </a>
            </form>
        </x-auth.card>
    </main>
</x-auth-layout>
</html>
