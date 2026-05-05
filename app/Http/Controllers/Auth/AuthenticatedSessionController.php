<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\OtpCodeMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthenticatedSessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Vérification email/password via Breeze
        $request->authenticate();

        $user = Auth::user();

        // 2. Vérification du statut actif (ta colonne is_active)
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => 'Votre compte est suspendu.']);
        }

        // 3. Génération du code OTP
        $otpCode = rand(100000, 999999);

        // 4. Stockage en session (plus simple que de modifier la DB)
        session([
            'auth_id' => $user->id,
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10),
            'remember' => $request->boolean('remember')
        ]);

        // 5. Envoi du mail
        Mail::to($user->email)->send(new OtpCodeMail($otpCode));

        // 6. Déconnexion forcée pour attendre le code
        Auth::logout();

        return redirect()->route('two-factor');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            $user->update([
                'last_logout_at' => now(),
                'last_seen_at' => now()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}