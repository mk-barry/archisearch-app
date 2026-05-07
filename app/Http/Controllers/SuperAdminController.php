<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Documents;
use App\Models\AuditLog;
use Illuminate\Http\Request;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    public function settings()
    {
        return view('super-admin.settings');
    }
    public function creationAdmin()
    {
        return view('super-admin.creation-admin');
    }
}