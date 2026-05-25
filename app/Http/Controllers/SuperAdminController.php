<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Documents;
use App\Models\DocumentType;
use App\Models\AuditLog;
use App\Models\Events;
use Illuminate\Http\Request;
use App\Models\AuthorizedStudent;
use App\Models\FileExtension;
use App\Models\SavedSearch;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index() {}

    public function dashboard()
    {
        // --- STATS GRID ---
        $totalAdmins = User::count();
        $activeAdmins = User::where('is_active', true)->count();

        // Exemple pour les documents (à adapter selon ta table)
        $totalDocs = Documents::count();
        $docsThisWeek = Documents::where('created_at', '>=', now()->startOfWeek())->count();

        // Anomalies (ex: documents rejetés ou erreurs de checksum)
        $anomalies = Documents::where('status', 'rejected')->count();

        // --- CHART 1 : ACTIVITÉ (7 derniers jours) ---
        $days = collect(range(6, 0))->map(function ($i) {
            // ucfirst pour mettre la majuscule (ex: Lun)
            return ucfirst(now()->subDays($i)->translatedFormat('D'));
        });


        $searches = SavedSearch::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->pluck('total', 'date');

        $uploads = Documents::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->pluck('total', 'date');

        // Simulation de données (à remplacer par des requêtes count() groupées par date)
        // $searchData = [85, 102, 91, 130, 118, 32, 18];
        // $uploadData = collect(range(6, 0))->map(function ($i) {
        //     $date = now()->subDays($i)->format('Y-m-d');
        //     return [
        //         // 'label' => ucfirst(now()->subDays($i)->translatedFormat('D')),
        //         'data' => Documents::whereDate('created_at', $date)->count()
        //     ];
        // });

        $uploadData = collect(range(6, 0))->map(function ($i) use ($uploads) {

            $date = now()->subDays($i)->format('Y-m-d');

            return $uploads[$date] ?? 0;
        });

        $searchData = collect(range(6, 0))->map(function ($i) use ($searches) {

            $date = now()->subDays($i)->format('Y-m-d');

            return $searches[$date] ?? 0;
        });

        // --- CHART 2 : RÉPARTITION ---
        $eventCounts = Events::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $eventStats = [
            'actifs'   => $eventCounts['actif'] ?? 0,
            'clotures' => $eventCounts['cloturé'] ?? 0,
            'archives' => $eventCounts['archivé'] ?? 0,
        ];

        // --- ACTIVITÉ RÉCENTE ---
        $recentActivities = AuditLog::with('user')->latest()->take(3)->get();

        // --- UTILISATEURS EN LIGNE ---
        $onlineUsers = User::where('last_seen_at', '>=', now()->subMinutes(1))->take(5)->get();

        return view('super-admin.dashboard', compact(
            'activeAdmins',
            'totalAdmins',
            'totalDocs',
            'docsThisWeek',
            'anomalies',
            'searchData',
            'uploadData',
            'days',
            'eventStats',
            'recentActivities',
            'onlineUsers'
        ));
    }

    public function logs(Request $request)
    {
        // On récupère les logs avec leurs relations
        $query = AuditLog::with(['user', 'actionDescription']);

        // On pagine par 10 (indispensable pour la pagination)
        $recentActivities = $query->latest()->paginate(10)->withQueryString();

        // Si c'est une requête AJAX (clic sur un numéro de page)
        if ($request->ajax()) {
            return response()->json([
                'table' => view('super-admin.logs', compact('recentActivities'))->fragment('logs-table')->render(),
                'pagination' => view('super-admin.logs', compact('recentActivities'))->fragment('pagination')->render()
            ]);
        }

        return view('super-admin.logs', compact('recentActivities'));
    }

    public function indexStudents(Request $request)
    {
        $query = AuthorizedStudent::withCount('documents');

        // --- RECHERCHE ---
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('matricule', 'like', "%{$request->search}%");
            });
        }

        // --- FILTRES ---
        if ($request->filled('filters')) {
            foreach ($request->filters as $filter) {
                if ($filter == 'has_uploads')
                    $query->has('documents');
                if ($filter == 'no_uploads')
                    $query->doesntHave('documents');
            }
        }

        // // --- TRI ---
        // $sortData = $request->input('sort');
        // if ($sortData) {
        //     $currentSort = is_array($sortData) ? end($sortData) : $sortData;
        //     switch ($currentSort) {
        //         case 'az':
        //             $query->orderBy('name', 'asc');
        //             break;
        //         case 'za':
        //             $query->orderBy('name', 'desc');
        //             break;
        //         case 'plusdocs':
        //             $query->orderByDesc('documents_count');
        //             break;
        //         case 'moinsdocs':
        //             $query->orderBy('documents_count', 'asc');
        //             break;
        //         default:
        //             $query->latest();
        //     }
        // } else {
        //     $query->latest();
        // }

        $query->latest();

        // Utilise paginate(5) comme pour tes admins pour tester la pagination
        $students = $query->paginate(5)->withQueryString();

        return view('super-admin.students', compact('students'));
    }
    public function createStudent()
    {
        return view("super-admin.create-students");
    }

    /**
     * Enregistre un nouvel étudiant dans la table authorized_students
     */
    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:50|unique:authorized_students,matricule',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
        ], [
            'matricule.unique' => 'Ce matricule est déjà enregistré.',
        ]);

        AuthorizedStudent::create([
            'matricule' => $validated['matricule'],
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return response()->json([
            'success' => true,
            'message' => "L'étudiant a été autorisé avec succès.",
            'redirect' => route('super-admin.students') // Ou la route de ton choix
        ]);
    }

    public function settings()
    {
        $documentTypes = DocumentType::with(['allowedExtensions', 'documents'])->get();
        $fileExtensions = FileExtension::all(); // On récupère la liste des formats existants
        $documents = Documents::all();
        $maxStorage = 15;
        $currentStorage = 0;

        foreach ($documents as $docs) {
            $currentStorage = $currentStorage + $docs->file_size;
        }
        return view('super-admin.settings', compact('documentTypes', 'fileExtensions', 'maxStorage', 'currentStorage'));
    }

    public function storeDocType(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'code' => 'required|string|unique:document_types,code|max:10',
            'max_size_mb' => 'required|integer|min:1', // On saisit en Mo pour l'UI
            'keywords' => 'nullable|string',
            'min_score' => 'required|integer|min:1',
            'extensions' => 'required|array', // Tableau d'IDs d'extensions
        ]);

        try {
            DB::beginTransaction();

            // 1. Création du type de document
            $documentType = DocumentType::create([
                'label' => $validated['label'],
                'code' => strtoupper($validated['code']),
                'max_size_kb' => $validated['max_size_mb'] * 1024, // Conversion en Ko pour la BD
                'validation_rules' => [
                    'keywords' => array_map('trim', explode(',', $request->keywords)),
                    'min_score' => (int)$validated['min_score']
                ]
            ]);

            // 2. Association des extensions (Table document_type_extension)
            $documentType->allowedExtensions()->attach($validated['extensions']);

            DB::commit();
            return back()->with('success', 'Type de document configuré avec succès !');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            DB::rollback();
            return back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    public function storeExtension(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:file_extensions,name|max:10',
            // 'mime_type' => 'required|string|max:100'
        ]);

        FileExtension::create([
            'name' => strtolower($validated['name']),
            'mime_type' => strtolower("application/" . $validated['name'])
        ]);

        return back()->with('success', 'Extension ajoutée avec succès !');
    }



    public function destroyExtension(FileExtension $extension)
    {
        // Vérifie si l'extension est liée à des types de documents
        if ($extension->documentTypes()->exists()) {

            return back()->with(
                'error',
                'Impossible de supprimer cette extension car elle est utilisée par un type de document.'
            );
        }

        // Vérifie si des documents utilisent cette extension
        $isUsedInDocuments = Documents::whereRaw(
            'LOWER(file_type) = ?',
            [strtolower($extension->name)]
        )->exists();

        if ($isUsedInDocuments) {

            return back()->with(
                'error',
                'Impossible de supprimer cette extension car des documents l’utilisent.'
            );
        }

        $extension->delete();

        return back()->with(
            'success',
            'Extension supprimée avec succès.'
        );
    }

    public function creationAdmin()
    {
        return view('super-admin.creation-admin');
    }
}
