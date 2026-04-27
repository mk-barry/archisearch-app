<?php

namespace App\Http\Controllers;

use App\Models\User; // Ne pas oublier !
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Pour crypter le mot de passe

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

        return redirect()->route('users.index')->with('success', 'Administrateur créé avec succès.');
    }
    public function edit(string $id)
    {
        $user = User::findOrFail($id); // Trouve l'user ou affiche une erreur 404
        return view("super-admin.edit-admin", compact("user"));
    }

    /**
     * Met à jour l'administrateur
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'organisation' => 'nullable|string'
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Profil mis à jour.');
    }

    /**
     * Supprime l'administrateur
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('danger', 'Administrateur supprimé.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'active' : 'desactive';
        return back()->with('success', 'Le compte a ete $status avec succes.');
    }
}