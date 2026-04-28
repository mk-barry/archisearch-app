<?php

namespace App\Http\Controllers;

use App\Models\User; // Ne pas oublier !
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Pour crypter le mot de passe
use Illuminate\Support\Facades\DB; 

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
        }

        $users = $query->paginate(5)->withQueryString();

        // Si c'est de l'AJAX, Laravel peut quand même renvoyer la vue entière, 
        // mais le JS ne prendra que ce dont il a besoin.
        // OU tu peux forcer le retour du fragment pour gagner en performance :
        if ($request->ajax()) {
            return view('super-admin.administrateurs', compact('users'))->fragment('table-body');
        }

        return view('super-admin.administrateurs', compact('users'));
    }

    public function create()
    {
        return view("super-admin.create-admin");
    }

    /**
     * Enregistre un nouvel administrateur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'organisation' => 'nullable|string'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'organisation' => $request->organisation,
        ]);
        // 
        return redirect()->route('users.index')->with('success', 'Administrateur créé avec succès.');
    }
    public function edit(string $id)
    {
        $user = User::findOrFail($id); // Trouve l'user ou affiche une erreur 404

        // On enlève DB::raw() et on passe directement la string
        $results = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'");

        if (empty($results)) {
            abort(500, "La colonne 'role' est introuvable.");
        }

        $type = $results[0]->Type;

        // Extraction des valeurs de l'enum
        preg_match('/^enum\((.*)\)$/', $type, $matches);

        $roles = [];
        if (isset($matches[1])) {
            foreach (explode(',', $matches[1]) as $value) {
                $roles[] = trim($value, "'");
            }
        }
        return view("super-admin.edit-admin", compact("user", "roles"));
    }

    /**
     * Met à jour l'administrateur
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'organisation' => 'nullable|string',
            'role' => 'required|in:super-admin,admin',
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Profil mis à jour.');
    }

    /**
     * Supprime l'administrateur
     */
    // public function destroy(string $id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->delete();

    //     return redirect()->route('users.index')->with('danger', 'Administrateur supprimé.');
    // }

    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activé' : 'désactivé';
        return back()->with('success', 'Le compte a été '. $status .' avec succès.');
    }

    // public function toggleStatus(User $user)
    // {
    //     $me = auth()->user();

    //     // 1. Interdire de s'auto-modifier
    //     if ($me->id === $user->id) {
    //         return back()->with('danger', "Action impossible : vous ne pouvez pas modifier votre propre statut.");
    //     }

    //     // 2. Le PREMIER Super-Admin (ID = 1) est intouchable
    //     if ($user->id === 1) {
    //         return back()->with('danger', "Action interdite : cet administrateur est le propriétaire racine du système.");
    //     }

    //     // 3. Empêcher de modifier quelqu'un de même rang (Super-Admin vs Super-Admin)
    //     if ($me->role === $user->role) {
    //         return back()->with('danger', "Action refusée : vous ne pouvez pas modifier un administrateur de même rang.");
    //     }

    //     $user->update(['is_active' => !$user->is_active]);
    //     $status = $user->is_active ? 'activé' : 'désactivé';

    //     return back()->with('success', "Le compte de {$user->name} a été {$status}.");
    // }

    // public function resetPassword(User $user)
    // {
    //     // Générer un mot de passe aléatoire de 10 caractères
    //     $newPassword = Str::random(10);

    //     $user->update([
    //         'password' => Hash::make($newPassword),
    //         'must_change_password' => true, // On force le changement au prochain login
    //     ]);

    //     // On renvoie le mot de passe dans le message pour que le Super-Admin puisse le copier
    //     return back()->with('success', "Mot de passe réinitialisé ! Nouveau pass : {$newPassword}");
    // }
}