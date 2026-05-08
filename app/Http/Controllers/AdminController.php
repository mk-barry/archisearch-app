<?php

namespace App\Http\Controllers;
use App\Models\Events;
use App\Models\AuthorizedStudent;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function evenements(Request $request)
    {
        $query = Events::query();

        // Filtre Recherche
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filtre Statut
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $events = $query->latest()->paginate(6); // 9 par page pour une grille 3x3

        // Si c'est de l'AJAX, on peut renvoyer juste la vue
        if ($request->ajax()) {
            return view('admin.evenements', compact('events'));
        }

        return view('admin.evenements', compact('events'));
    }

    public function cloturePrematuree(Events $event)
    {
        $event->update([
            'status' => 'cloture',
            'end_date' => now(),
        ]);

        return back()->with('success', "L'événement a été clôturé avec succès.");
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'invite_type' => 'required|in:tous,particuliers',
            'invited_students' => 'required_if:invite_type,particuliers|array',
            // ... tes autres validations
        ]);

        // 1. Création de l'événement
        $event = Events::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'invite_type' => $request->invite_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            // On prend directement le tableau envoyé par Select2
            'required_docs' => $request->required_docs,
            'status' => 'actif',
            // N'oublie pas l'UUID si ton modèle ne le génère pas seul
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
        ]);

        // 2. Si mode particuliers, on remplit la table pivot
        if ($request->invite_type === 'particuliers' && $request->has('invited_students')) {
            // Utilise le nom de la relation définie dans ton modèle Events
            $event->authorizedStudents()->attach($request->invited_students);
        }

        return response()->json(['success' => true]);
    }
    public function creationEvent()
    {
        // On récupère tous les étudiants pour pouvoir les afficher dans le Select2
        $AuthorizedStudent = AuthorizedStudent::all();

        // On injecte la variable dans la vue
        return view('admin.creation-events', compact('AuthorizedStudent'));
    }
    public function documents()
    {
        return view('admin.documents');
    }
    public function recherche()
    {
        return view('admin.recherche');
    }
    public function archives()
    {
        return view('admin.archives');
    }
    public function cloud()
    {
        return view('admin.cloud');
    }
}