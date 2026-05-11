<?php

namespace App\Http\Controllers;
use App\Models\Events;
use App\Models\DocumentType;
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
        // 1. Validation stricte
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'invite_type' => 'required|in:tous,particuliers',
            'document_types' => 'required|array|min:1', // On valide le nouveau nom du champ
            'invited_students' => 'required_if:invite_type,particuliers|array',
        ]);

        // 2. Création de l'événement
        $event = Events::create([
            'user_id' => auth()->id(),
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'title' => $request->title,
            'description' => $request->description,
            'invite_type' => $request->invite_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'actif',
            // 'required_docs' est retiré ici car on utilise la table pivot
        ]);

        // 3. Liaison des types de documents (Table pivot event_document_type)
        $event->documentTypes()->sync($request->document_types);

        // Liaison des étudiants (CORRIGÉ ICI)
        if ($request->invite_type === 'particuliers' && $request->has('invited_students')) {
            // sync est préférable à attach pour éviter les doublons
            $event->authorizedStudent()->sync($request->invited_students);
        }

        // 5. Retour JSON avec succès et redirection pour ton script JS
        return response()->json([
            'success' => true,
            'redirect' => route('admin.evenements'),
            'message' => 'Événement créé avec succès !'
        ]);
    }
    public function creationEvent()
    {
        $documentTypes = DocumentType::all(); // On récupère les types de docs
        $authorizedStudents = AuthorizedStudent::all(); // On récupère les étudiants

        // On injecte la variable dans la vue
        return view('admin.creation-events', compact('authorizedStudents', 'documentTypes'));
    }

    public function editEvent($uuid)
    {
        // 1. On récupère l'événement avec ses relations
        $event = Events::with('documentTypes')->where('uuid', $uuid)->firstOrFail();

        // 2. On récupère tous les types de documents disponibles en BD 
        // pour pouvoir les afficher sous forme de checkboxes dans le formulaire
        $documentTypes = DocumentType::all();

        // 3. On retourne la VUE (le fichier .blade.php) et on lui passe les données
        return view('admin.edit-event', compact('event', 'documentTypes'));
    }

    public function update(Request $request, $uuid)
    {
        $event = Events::where('uuid', $uuid)->firstOrFail();

        // Validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'invite_type' => 'required|in:tous,particuliers',
            'status' => 'required|in:actif,cloture,archive,brouillon',
        ]);

        // Update
        $event->update($validated);

        // RÉPONSE CRUCIALE POUR LE FETCH
        return response()->json([
            'success' => true,
            'message' => 'Événement mis à jour',
            'redirect' => route('admin.evenements')
        ]);
    }

    public function showEvent($uuid)
    {
        // On récupère l'événement avec ses types de docs et les étudiants liés
        $event = Events::with(['documentTypes', 'authorizedStudent'])
                       ->where('uuid', $uuid)
                       ->firstOrFail();

        return view('admin.voir-event', compact('event'));
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