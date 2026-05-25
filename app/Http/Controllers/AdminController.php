<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\User;
use App\Models\Documents;
use App\Models\DocumentType;
use App\Models\AuthorizedStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process; // Import indispensable
use App\Http\Controllers\Log;
// use App\Http\Controllers\Storage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use ZipArchive;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Stats des Cartes
        $stats = [
            'evenements_actifs' => Events::where('status', 'actif')->count(),
            'docs_recus_semaine' => Documents::where('created_at', '<=', now()->startOfWeek())->count(),
            'en_attente' => Documents::where('status', 'pending')->count(),
            'anomalies' => Documents::where('rejection_reason', 'like', '%fraude%')
                ->orWhere('status', 'rejected')->count(),
        ];

        // 2. Données pour le Graphique (7 derniers jours)
        $last7Days = collect(range(6, 0))->map(function ($i) {
            $date = now()->subDays($i)->format('Y-m-d');
            return [
                'label' => ucfirst(now()->subDays($i)->translatedFormat('D')),
                'count' => Documents::whereDate('created_at', $date)->count()
            ];
        });

        // 3. Stats des événements (Progress bars)
        $evenementStats = [
            'actifs' => Events::where('status', 'actif')->count(),
            'clotures' => Events::where('status', 'cloturé')->count(),
            'brouillons' => Events::where('status', 'brouillon')->count(),
            'archives' => Events::where('status', 'archivé')->count(),
            'total' => Events::count() ?: 1, // Éviter division par 0
        ];

        // 4. Derniers téléversements
        $derniersDocs = Documents::with(['student', 'event'])
            ->latest()
            ->take(4)
            ->get();

        // 5. Invités sans soumission (Exemple : Users qui n'ont aucun document lié)
        $invitesEnAttente = AuthorizedStudent::where('matricule')
            ->whereDoesntHave('documents')
            ->latest()
            ->take(4)
            ->get();

        return view('admin.dashboard', compact('stats', 'last7Days', 'evenementStats', 'derniersDocs', 'invitesEnAttente'));
    }

    // =======================================================================================
    // =====================================Evenements========================================
    // =======================================================================================

    public function evenements(Request $request)
    {
        Events::where('status', 'actif')
            ->where('end_date', '<', now())
            ->update([
                'status' => 'cloturé'
            ]);

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
            'status' => 'cloturé',
            'end_date' => now(),
        ]);

        return back()->with('success', "L'événement a été clôturé avec succès.");
    }

    public function storeEvent(Request $request)
    {
        // 1. Validation stricte
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'invite_type' => 'required|in:tous,particuliers',
                'document_types' => 'required|array|min:1', // On valide le nouveau nom du champ
                'invited_students' => 'required_if:invite_type,particuliers|array',
            ],
            [
                'start_date.after_or_equal' =>
                "La date de début ne peut pas être dans le passé.",

                'end_date.after_or_equal' =>
                "La date de fin doit être après la date de début.",
            ]
        );

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

        if ($event->status === "actif") {

            // 2. On récupère tous les types de documents disponibles en BD 
            // pour pouvoir les afficher sous forme de checkboxes dans le formulaire
            $documentTypes = DocumentType::all();

            // 3. On retourne la VUE (le fichier .blade.php) et on lui passe les données
            return view('admin.edit-event', compact('event', 'documentTypes'));
        } else {
            return back();
        }
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
            'status' => 'required|in:actif,cloturé,archivé,brouillon',
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

    // =======================================================================================
    // =====================================Documents=========================================
    // =======================================================================================

    public function documents(Request $request)
    {
        $query = Documents::with(['student', 'documentType']);

        // --- RECHERCHE ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('file_path', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // --- FILTRE TYPE ---
        if ($request->filled('type') && $request->type !== 'Tous') {
            $query->where('file_type', 'like', "%" . strtolower($request->type) . "%");
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        // --- LOGIQUE DE FRAGMENT ---
        if ($request->ajax()) {
            // Si ton JS attend un objet JSON avec deux clés différentes :
            return response()->json([
                'table-body' => view('admin.documents', compact('documents'))->fragment('table-body'),
                'pagination' => view('admin.documents', compact('documents'))->fragment('pagination'),
            ]);
        }

        return view('admin.documents', compact('documents'));
    }

    public function showDocumentAnalysis(Documents $document)
    {
        try {

            $metadata = is_string($document->metadata)
                ? json_decode($document->metadata, true)
                : ($document->metadata ?? []);

            $text = $metadata['extracted_text']
                ?? $document->extracted_text
                ?? '';

            $student = $document->student;

            $documentType = $document->documentType;

            $rules = $documentType?->validation_rules;

            if (is_string($rules)) {
                $rules = json_decode($rules, true);
            }

            $payload = [

                'text' => $text,

                'student' => [
                    'name' => $student?->name,
                    'matricule' => $student?->matricule,
                    'email' => $student?->email,
                ],

                'rules' => [

                    'required_keywords' => (
                        $rules['required_keywords'] ?? []
                    ),

                    'forbidden_keywords' => (
                        $rules['forbidden_keywords'] ?? []
                    ),

                    'metadata_patterns' => (
                        $rules['metadata_patterns'] ?? []
                    ),

                    'minimum_confidence' => (
                        $rules['minimum_confidence'] ?? 70
                    ),

                    'is_perishable' => (
                        (bool)($documentType?->is_perishable ?? false)
                    )
                ]
            ];

            $pythonPath = base_path(
                '.venv/Scripts/python.exe'
            );

            $scriptPath = base_path(
                'scripts/deep_analysis.py'
            );

            $process = \Illuminate\Support\Facades\Process::run([
                $pythonPath,
                $scriptPath,
                json_encode(
                    $payload,
                    JSON_UNESCAPED_UNICODE
                )
            ]);

            if ($process->failed()) {

                throw new \Exception(
                    $process->errorOutput()
                );
            }

            $analysis = json_decode(
                $process->output(),
                true
            );

            if (!$analysis) {

                throw new \Exception(
                    'Réponse Python invalide'
                );
            }

            // =================================================
            // SAVE ANALYSIS
            // =================================================

            $document->metadata = array_merge(
                $metadata,
                [
                    'analysis' => $analysis
                ]
            );

            $document->save();

            return view(
                'admin.doc-view',
                compact(
                    'document',
                    'analysis'
                )
            );
        } catch (\Exception $e) {

            \Log::error(
                "Erreur Expertise : " .
                    $e->getMessage()
            );

            return redirect()
                ->route('admin.documents')
                ->with(
                    'error',
                    'Analyse impossible : ' .
                        $e->getMessage()
                );
        }
    }

    public function updateStatus(Request $request, Documents $document)
    {
        $request->validate([
            'status' => 'required|in:validated,rejected,pending,error',
            'comment' => 'required_if:status,rejected|nullable|string|min:5'
        ], [
            'comment.required_if' => 'Veuillez preciser le motif du rejet',
            'comment.min' => 'Le motif doit etre plus detaille (min. 5 caracteres)'
        ]);

        try {
            $document->update([
                'status' => $request->status,
                'rejection_reason' => $request->comment,
                'processed_at' => now(),
                'processed_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Le statut du document a été mis à jour avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()
            ], 500);
        }
    }

    // Télécharger un document unique
    public function downloadDocument(Documents $document)
    {
        return \Storage::disk('public')->download($document->file_path);
    }

    // Supprimer un document
    public function destroyDocument(Documents $document)
    {
        // Supprimer le fichier physique
        \Storage::disk('public')->delete($document->file_path);
        // Supprimer l'entrée en base de données
        $document->delete();

        return response()->json(['success' => true]);
    }

    // Actions groupées (Bulk)
    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if (!$ids || count($ids) === 0) return response()->json(['error' => 'Aucun document sélectionné'], 400);

        if ($action === 'archive') {
            Documents::whereIn('id', $ids)->update(['status' => 'Archivé']);
            return response()->json(['success' => true]);
        }

        if ($action === 'download') {
            $zip = new ZipArchive;
            $zipName = 'documents_export_' . time() . '.zip';
            $zipPath = storage_path('app/public/' . $zipName);

            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                $files = Documents::whereIn('id', $ids)->get();
                foreach ($files as $file) {
                    $filePath = storage_path("app/public/" . $file->file_path);
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, basename($file->file_path));
                    }
                }
                $zip->close();
                return response()->download($zipPath)->deleteFileAfterSend(true);
            }
        }

        return response()->json(['error' => 'Action inconnue'], 400);
    }

    // =======================================================================================
    // =====================================Recherche=========================================
    // =======================================================================================
    public function recherche(Request $request)
    {
        $query = Documents::query()
            ->with([
                'student',
                'event'
            ]);

        // =====================================================
        // SEARCH
        // =====================================================

        if ($request->filled('q')) {

            $search = $request->q;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'title',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'extracted_text',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas('student', function ($sq) use ($search) {

                        $sq->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        // =====================================================
        // EVENT
        // =====================================================

        if ($request->filled('event')) {

            $query->where(
                'event_id',
                $request->event
            );
        }

        // =====================================================
        // DATE
        // =====================================================

        // if ($request->filled('date')) {

        //     $query->whereDate(
        //         'created_at',
        //         $request->date
        //     );
        // }

        // =====================================================
        // TYPE
        // =====================================================

        if ($request->filled('type')) {

            $query->where(
                'file_type',
                $request->type
            );
        }


        // =====================================================
        // AUTHOR
        // =====================================================

        if ($request->filled('student')) {

            $query->whereHas('student', function ($q) use ($request) {

                $q->where(
                    'name',
                    $request->uploader
                );
            });
        }

        // =====================================================
        // STATUS
        // =====================================================

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        // =====================================================
        // RESULTS
        // =====================================================

        $results = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // =====================================================
        // FILTER DATA
        // =====================================================

        $events = Events::orderBy('title')->get();

        $uploaders = AuthorizedStudent::orderBy('name')->get();

        $types = DocumentType::orderBy('code')->get();

        $enum = DB::select("SHOW COLUMNS FROM documents WHERE Field = 'status'");

        $type = $enum[0]->Type;

        preg_match('/^enum\((.*)\)$/', $type, $matches);

        $statuses = [];

        if (isset($matches[1])) {

            foreach (explode(',', $matches[1]) as $value) {

                $statuses[] = trim($value, "'");
            }
        }

        // =====================================================
        // SAVED SEARCHES
        // =====================================================

        $savedSearches = auth()
            ->user()
            ->savedSearches()
            ->latest()
            ->take(10)
            ->get();

        // =====================================================
        // AJAX RESPONSE
        // =====================================================

        if ($request->ajax()) {

            return response()->json([

                'html' => view(
                    'admin.partials.search-result',
                    compact('results')
                )->render(),

                'count' => $results->total()
            ]);
        }

        return view(
            'admin.recherche',
            compact(
                'results',
                'savedSearches',
                'events',
                'uploaders',
                'types',
                'statuses'
            )
        );
    }

    // Fonction pour sauvegarder via AJAX
    public function sauvegarderRecherche(Request $request)
    {
        auth()->user()->savedSearches()->create([
            'keyword' => $request->q,
            'filters' => [
                'status' => $request->status,
                'date' => $request->date
            ]
        ]);

        return response()->json(['success' => true]);
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
