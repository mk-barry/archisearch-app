<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Affiche la page de profil
     */
    public function edit()
    {
        return view('profile', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Met à jour les informations du profil
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                'password' => ['nullable', 'confirmed', Password::defaults()],
                'old_password' => ['required_with:password', 'current_password'],
            ],
            [
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
                'old_password.current_password' => 'Le mot de passe actuel est incorrect.',
                'password_confirmation.required_with' => 'Veuillez confirmer le nouveau mot de passe.',
            ]
        );

        // Gestion de l'avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_path = $path;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès !');
    }
}
