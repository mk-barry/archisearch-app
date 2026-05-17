<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\AuthorizedStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Response;
use App\Models\Documents;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;


class GuestController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function twoFactor()
    {
        return view('auth.two-factor');
    }

    /**
     * Étape 0 : Page d'invitation (Landing)
     */
    public function invitation($uuid)
    {
        $event = Events::with('documentTypes')->where('uuid', $uuid)->firstOrFail();
        return view('user.invitation', compact('event'));
    }

    /**
     * Étape 1 : Formulaire d'identification
     */
    public function identification($uuid)
    {
        $event = Events::where('uuid', $uuid)->firstOrFail();
        return view('user.identification', compact('event'));
    }

    /**
     * Étape 2 : Traitement de l'identification (Logique demandée)
     */
    public function verifyIdentification(Request $request, $uuid)
    {
        $request->validate([
            'identifier' => 'required', // matricule
            'fullname'   => 'required'   // nom
        ]);

        $event = Events::where('uuid', $uuid)->firstOrFail();

        // 1. & 2. Vérification Matricule et Nom (et optionnellement email si tu l'ajoutes)
        $student = AuthorizedStudent::where('matricule', $request->identifier)->first();

        // On vérifie si l'étudiant existe et si le nom correspond (insensible à la casse)
        if (!$student || !Str::contains(strtolower($student->name), strtolower($request->fullname))) {
            return back()->with('error', 'Matricule ou nom non reconnu dans notre base de données.');
        }

        // 3. Vérification si l'événement est actif/ouvert
        $isClosed = ($event->status !== 'actif' || Carbon::now()->gt($event->end_date));

        // 4. Vérification Restriction (invite_type)
        if ($event->invite_type === 'particuliers') {
            $isAuthorized = DB::table('event_authorized_student')
                ->where('event_id', $event->id)
                ->where('authorized_student_id', $student->id)
                ->exists();

            if (!$isAuthorized) {
                return back()->with('error', "Vous n'êtes pas autorisé à accéder à cet événement, veuillez vous rapprocher de l'admin.");
            }
        }

        // Stockage en session unique
        session([
            'student_id'        => $student->id,
            'student_name'      => $student->name,
            'student_matricule' => $student->matricule,
            'auth_event_uuid'   => $uuid
        ]);

        // Redirection vers l'interface (Dépôt ou Historique selon $isClosed)
        return redirect()->route('invitation.upload', ['uuid' => $uuid]);
    }

    /**
     * Étape 3 : Interface de téléchargement ou Historique
     */
    public function upload($uuid)
    {
        $event = Events::with('documentTypes')->where('uuid', $uuid)->firstOrFail();

        // Sécurité session
        if (session('auth_event_uuid') !== $uuid) {
            return redirect()->route('invitation.identification', $uuid);
        }

        $student_id = session('student_id');
        $isClosed = ($event->status !== 'actif' || Carbon::now()->gt($event->end_date));

        // On récupère les documents déjà soumis par cet étudiant pour cet événement
        $submissions = Documents::where('event_id', $event->id)
            ->where('identifier', session('student_matricule'))
            ->get();

        return view('user.televersement', compact('event', 'isClosed', 'submissions'));
    }

    /**
     * Étape 4 : Traitement du fichier (Logique demandée)
     */
    public function storeDocument(Request $request, $uuid)
    {
        $event = Events::where('uuid', $uuid)->firstOrFail();
        $docType = DocumentType::where('id', $request->document_type_id)->firstOrFail();

        $request->validate([
            'document' => ['required', 'file', 'mimes:pdf,jpg,png,jpeg', 'max:' . ($docType->max_size_kb ?? 2048)]
        ]);

        $file = $request->file('document');
        $matricule = session('student_matricule');
        $path = $file->storeAs("documents/{$matricule}/{$event->id}", time() . '_' . $file->getClientOriginalName(), 'public');
        $fullPath = storage_path("app/public/" . $path);
        $pythonPath = base_path('.venv\Scripts\python.exe');

        // --- LOGIQUE OCR ---
        $scriptPath = base_path('scripts/ocr_script.py');

        // Préparation des règles JSON issues de ta BD
        $rules = json_encode([
            'keywords' => $docType->validation_rules['keywords'] ?? [],
            'min_score' => $docType->validation_rules['min_score'] ?? 1
        ]);

        // Exécution (Attention aux guillemets pour les chemins Windows/Linux)
        $process = Process::run([
            $pythonPath,
            $scriptPath,
            $fullPath,
            $rules
        ]);

        if (!$process->successful()) {
            \Storage::disk('public')->delete($path);
            $errorOutput = $process->errorOutput(); // Récupère l'erreur réelle de Python
            \Log::error("Erreur OCR : " . $errorOutput); // Écrit l'erreur dans storage/logs/laravel.log
            return response()->json(['success' => false, 'message' => 'Erreur technique OCR.'], 500);
        }

        $ocrData = json_decode($process->output(), true);

        // Si le script Python renvoie un statut d'erreur ou is_valid = false
        if ($ocrData['status'] === 'error' || (isset($ocrData['is_valid']) && !$ocrData['is_valid'])) {
            \Storage::disk('public')->delete($path);
            return response()->json([
                'success' => false,
                'message' => 'Document non conforme : ' . ($ocrData['message'] ?? 'Critères de validation non atteints.')
            ], 422);
        }

        // --- ENREGISTREMENT FINAL ---
        $document = Documents::create([
            'event_id' => $event->id,
            'document_type_id' => $docType->id,
            'identifier' => $matricule,
            'tracking_code' => 'AS-' . strtoupper(Str::random(8)),
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => round($file->getSize() / 1024),
            'category' => $docType->label,
            'status' => 'pending',
            'metadata' => [
                'score_ocr' => $ocrData['score'],
                'mots_trouves' => $ocrData['match_keywords'] ?? [],
                'validated_at' => now()->toDateTimeString()
            ],
            'extracted_text' => $ocrData['extracted_text'] ?? ''
        ]);

        return response()->json(['success' => true, 'message' => 'Document validé et enregistré.']);
    }

    public function confirmation(Request $request, $uuid)
    {
        // 1. Récupérer les identifiants de base
        $matricule = session('student_matricule');
        // $uuid = $request->query('uuid');
        // dd($uuid);

        // 2. Trouver l'événement correspondant à l'UUID
        // On récupère l'événement en premier pour avoir accès à son "id"
        $event = Events::where('uuid', $uuid)->first();
        // dd($event);

        // Sécurité : Si l'événement n'existe pas, on redirige ou on affiche une erreur
        if (!$event) {
            return redirect()->back()->with('error', 'Événement introuvable.');
        }

        // 3. Récupérer les documents avec le double filtre :
        // - Appartenant à l'étudiant (identifier)
        // - Appartenant à cet événement précis (event_id)
        $documents = Documents::where('identifier', $matricule)
            ->where('event_id', $event->id) // Utilisation de l'ID numérique
            ->orderBy('created_at', 'desc')
            ->get();

        if ($documents->isEmpty()) {
            // On le renvoie vers la page de téléversement avec un message d'erreur
            return redirect()->route('invitation.upload', ['uuid' => $uuid])
                ->with('error', 'Vous devez téléverser au moins un document avant d\'accéder à la confirmation.');
        }

        // 4. Envoyer les données à la vue
        return view('user.confirmation', compact('documents', 'uuid', 'event'));
    }

    public function history()
    {
        // On vérifie que l'étudiant est bien identifié en session
        $matricule = session('student_matricule');

        if (!$matricule) {
            return redirect()->route('invitation.home', ['uuid' => 'index']) // Ou une page de login
                ->with('error', 'Veuillez vous identifier pour accéder à votre historique.');
        }

        // On récupère les événements où l'étudiant a au moins un document
        // avec le compte des documents par événement
        $events = Events::whereHas('documents', function ($query) use ($matricule) {
            $query->where('identifier', $matricule);
        })->withCount([
            'documents' => function ($query) use ($matricule) {
                $query->where('identifier', $matricule);
            }
        ])->latest()->get();

        return view('user.history', compact('events'));
    }

    /**
     * Déconnexion de la session étudiant
     */
    public function logout($uuid)
    {
        session()->forget(['student_id', 'student_name', 'student_matricule', 'auth_event_uuid']);
        return redirect()->route('invitation.home', $uuid);
    }
}
