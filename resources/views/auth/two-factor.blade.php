<x-auth-layout :hideHeader="true">
    <x-slot:title>Vérification 2FA - ArchiSearch</x-slot>
        <x-slot:breadcrumb_current>Vérification 2FA</x-slot>

            @push('styles')
                <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
                <link rel="stylesheet" href="{{ asset('css/auth/two-factor.css') }}">
            @endpush

            <main style="flex: 1; display: flex; align-items: center; justify-content: center;">
                <x-auth.card style="width: 500px; text-align: center; padding: 2rem 2.5rem;">
                    <div class="shield-icon-wrapper" style="margin-bottom: 0.5rem;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" />
                        </svg>
                    </div>

                    <h2 style="margin-bottom: 1.8rem; font-size: 1.5rem;">Vérification en deux étapes</h2>
                    <p class="subtitle" style="margin-bottom: 1.8rem;">Un code OTP à 6 chiffres a été envoyé
                        à<br><strong style="color: #1e293b;">a***n@exemple.gouv</strong></p>

                    <form action="{{ route('two-factor.verify') }}" method="POST">
                        @csrf

                        <input type="hidden" name="code" id="full-otp">

                        <div class="otp-container">
                            <input type="text" class="otp-box otp-input" maxlength="1" data-index="0" placeholder="•">
                            <input type="text" class="otp-box otp-input" maxlength="1" data-index="1" placeholder="•">
                            <input type="text" class="otp-box otp-input" maxlength="1" data-index="2" placeholder="•">
                            <input type="text" class="otp-box otp-input" maxlength="1" data-index="3" placeholder="•">
                            <input type="text" class="otp-box otp-input" maxlength="1" data-index="4" placeholder="•">
                            <input type="text" class="otp-box otp-input" maxlength="1" data-index="5" placeholder="•">
                        </div>

                        @if($errors->has('code'))
                            <span class="text-red-500 text-sm">{{ $errors->first('code') }}</span>
                        @endif



                        <button type="submit" class="submit-btn" style="margin: 1.2rem 0;">Vérifier le code</button>
                        <span>Vous n'avez pas reçu de code ?</span>
                        <div class="resend-text">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" />
                                <path d="M21 3v5h-5" />
                                <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" />
                                <path d="M3 21v-5h5" />
                            </svg>
                            <button id="resendBtn">Renvoyer le code <span class="resend-timer" id="timer"></span></button>
                        </div>

                        <a href="{{ route('login') }}" class="back-to-login">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                            Retour à la connexion
                        </a>

                    </form>
                </x-auth.card>
            </main>
            <script>
                const inputs = document.querySelectorAll('.otp-input');
                const hiddenInput = document.getElementById('full-otp');

                inputs.forEach((input, index) => {
                    input.addEventListener('input', (e) => {
                        // Passer à la case suivante
                        if (e.target.value.length === 1 && index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                        updateHiddenInput();
                    });

                    input.addEventListener('keydown', (e) => {
                        // Retour arrière : revenir à la case précédente
                        if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                            inputs[index - 1].focus();
                        }
                    });
                });

                function updateHiddenInput() {
                    let code = "";
                    inputs.forEach(input => code += input.value);
                    hiddenInput.value = code;
                }
            </script>

            <script>
                const expiresAt = new Date("{{ session('otp_expires_at') }}").getTime();

                const timer = document.getElementById('timer');
                const btn = document.getElementById('resendBtn');

                const interval = setInterval(() => {

                    const now = Date.now();
                    const diff = Math.floor((expiresAt - now) / 1000);

                    if (diff <= 0) {

                        clearInterval(interval);

                        btn.disabled = false;
                        // btn.textContent = "Renvoyer le code";

                        return;
                    }

                    const minutes = Math.floor(diff / 60);
                    const seconds = diff % 60;

                    timer.textContent =
                        `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                }, 1000);
            </script>
</x-auth-layout>

</html>