<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Documents;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Models\AuthorizedStudent;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {

    }

    public function dashboard()
    {
        // --- STATS GRID ---
        $totalAdmins = User::count();
        $activeAdmins = User::where('is_active', true)->count();

        // Exemple pour les documents (à adapter selon ta table)
        $totalDocs = Documents::count();
        $docsThisWeek = Documents::where('created_at', '>=', now()->startOfWeek())->count();

        // Anomalies (ex: documents rejetés ou erreurs de checksum)
        $anomalies = Documents::where('status', 'rejectes')->count();

        // --- CHART 1 : ACTIVITÉ (7 derniers jours) ---
        $days = collect(range(6, 0))->map(function ($i) {
            return now()->subDays($i)->format('D');
        });

        // Simulation de données (à remplacer par des requêtes count() groupées par date)
        $searchData = [85, 102, 91, 130, 118, 32, 18];
        $uploadData = [42, 67, 53, 88, 74, 20, 12];

        // --- CHART 2 : RÉPARTITION ---
        $eventStats = [
            'actifs' => 38, // Remplace par ta logique métier
            'clotures' => 22,
            'archives' => 15
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

        // --- TRI ---
        $sortData = $request->input('sort');
        if ($sortData) {
            $currentSort = is_array($sortData) ? end($sortData) : $sortData;
            switch ($currentSort) {
                case 'az':
                    $query->orderBy('name', 'asc');
                    break;
                case 'za':
                    $query->orderBy('name', 'desc');
                    break;
                case 'plusdocs':
                    $query->orderByDesc('documents_count');
                    break;
                case 'moinsdocs':
                    $query->orderBy('documents_count', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

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
        return view('super-admin.settings');
    }
    public function creationAdmin()
    {
        return view('super-admin.creation-admin');
    }
}