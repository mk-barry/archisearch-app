<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function resend()
{
    $otp = random_int(100000, 999999);

    session([
        'otp_code' => $otp,
        'otp_expires_at' => now()->addMinutes(10),
    ]);

    Mail::to(User::find(session('auth_id'))->email)
        ->send(new OtpCodeMail($otp));

    return back();
}

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|numeric|digits:6']);

        if (
            session('auth_id') &&
            $request->code == session('otp_code') &&
            now()->isBefore(session('otp_expires_at'))
        ) {

            // 1. On reconnecte l'utilisateur
            Auth::loginUsingId(session('auth_id'), session('remember'));
            $user = Auth::user(); // On récupère l'utilisateur connecté
            if ($user) {
                $user->update([
                    'last_login_at' => now(),
                    'last_seen_at' => now()
                ]);
            }

            // 2. Nettoyage
            session()->forget(['otp_code', 'auth_id', 'otp_expires_at', 'remember']);
            $request->session()->regenerate();

            // 3. LOGIQUE DE REDIRECTION PAR RÔLE
            if ($user->role === 'super-admin') {
                return redirect()->route('super-admin.dashboard');
            }

            // Par défaut, on envoie vers le dashboard admin classique
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['code' => 'Code incorrect ou expiré.']);
    }
}