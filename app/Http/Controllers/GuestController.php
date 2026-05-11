<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\AuthorizedStudent;
use Illuminate\Support\Facades\DB;
use App\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function invitation($uuid)
    {
        // On vérifie que l'événement existe
        $event = Events::where('uuid', $uuid)->firstOrFail();

        // On l'envoie à la vue 'home'
        return view('user.invitation', compact('event'));
    }
    // public function identification($uuid)
    // {
    //     // On cherche l'événement par son UUID ou on renvoie une erreur 404 s'il n'existe pas
    //     $event = Events::where('uuid', $uuid)->firstOrFail();

    //     // C'est ici qu'on passe la variable $event à la vue identification.blade.php
    //     return view('user.identification', compact('event'));
    // }
    public function identification($uuid)
    {
        // On récupère l'événement via l'UUID de l'URL
        $event = Events::where('uuid', $uuid)->firstOrFail();

        // On passe l'événement à la vue
        return view('user.identification', compact('event'));
    }
    public function upload($uuid)
    {
        // On cherche l'événement par l'UUID de l'URL
        $event = Events::where('uuid', $uuid)->firstOrFail();

        // La sécurité (clôture) dépend de cet événement précis
        $isClosed = now()->gt($event->end_date) || $event->status === 'cloturé';

        $userDocuments = Documents::where('event_id', $event->id)
            ->where('identifier', session('student_matricule'))
            ->get();

        return view('user.televersement', compact('event', 'userDocuments', 'isClosed'));
    }

    public function storeDocument(Request $request)
    {
        $event = Events::findOrFail($request->event_id);

        // 1. Validation stricte selon tes colonnes
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:' . ($event->max_file_size * 1024),
            'document_type' => 'required|string' // Correspond à ta 'category'
        ]);

        $file = $request->file('document');

        // 2. Préparation des données techniques
        $matricule = session('student_matricule');
        $extension = $file->getClientOriginalExtension();
        $sizeInKb = round($file->getSize() / 1024);

        // Génération d'un tracking_code unique pour ce dépôt (ex: AS-5X82ZP)
        $trackingCode = 'AS-' . strtoupper(Str::random(6));

        // 3. Stockage physique
        $path = $file->store('documents/' . $matricule);

        // 4. Insertion en BD alignée sur ta migration
        Documents::create([
            'event_id' => $event->id,
            'identifier' => $matricule,
            'tracking_code' => $trackingCode,
            'file_path' => $path,
            'file_type' => $extension,
            'file_size' => $sizeInKb,
            'category' => $request->document_type, // Ex: "CNI", "Contrat"
            'status' => 'submitted', // On l'initie en 'submitted' (soumis)
            'metadata' => [
                'original_name' => $file->getClientOriginalName(),
                'upload_ip' => $request->ip()
            ]
        ]);

        // 5. Redirection vers la confirmation avec le code de suivi
        // return redirect()->route('invitation.confirmation')
        //     ->with('tracking_code', $trackingCode);
        return redirect()->route('invitation.upload', ['uuid' => $event->uuid])
            ->with('success', 'Document ajouté !');
    }
    public function confirmation()
    {
        $matricule = session('student_matricule');

        // On récupère les documents pour l'affichage dynamique
        $documents = Documents::where('identifier', $matricule)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.confirmation', compact('documents'));
    }
    public function verifyIdentification(Request $request)
    {
        // On valide que les données arrivent bien
        $request->validate([
            'identifier' => 'required',
            'fullname' => 'required'
        ]);

        // On cherche l'étudiant
        $student = AuthorizedStudent::where('matricule', $request->identifier)->first();

        if (!$student) {
            return back()->with('error', 'Matricule non reconnu.');
        }

        // On stocke en session (attention à bien utiliser fullname ici)
        session([
            'student_id' => $student->id,
            'student_name' => $request->fullname,
            'student_matricule' => $student->matricule,
            'current_event_id' => $request->event_id // Stocké pour le téléversement
        ]);

        // On récupère l'UUID depuis un champ caché du formulaire ou la session
        $event = Events::findOrFail($request->event_id);

        // On redirige vers le téléversement AVEC l'UUID dans l'URL
        return redirect()->route('invitation.upload', ['uuid' => $event->uuid]);
    }
    public function accessEvent(Request $request, $uuid)
    {
        $event = Events::where('uuid', $uuid)->firstOrFail();

        // 1. Vérifier si l'étudiant est identifié en session
        if (!session()->has('student_id')) {
            return redirect()->route('invitation.identification', ['event' => $uuid]);
        }

        $studentId = session('student_id');

        // 2. Logique de restriction par type d'invitation
        if ($event->invite_type === 'particuliers') {
            $isInvited = \DB::table('event_authorized_student')
                ->where('event_id', $event->id)
                ->where('authorized_student_id', $studentId)
                ->exists();

            if (!$isInvited) {
                return abort(403, "Vous n'êtes pas sur la liste des invités pour cet événement.");
            }
        }

        return view('invitation.upload', compact('event'));
    }
    
    public function history()
    {
        $matricule = session('student_matricule');

        if (!$matricule) {
            return redirect()->route('invitation.home')->with('error', 'Veuillez vous identifier.');
        }

        // On récupère tous les événements où cet étudiant a déposé au moins un document
        $events = Events::whereHas('documents', function ($query) use ($matricule) {
            $query->where('identifier', $matricule);
        })->get();

        return view('invitation.history', compact('events'));
    }
    public function logout()
    {
        session()->forget([
            'student_id',
            'student_name',
            'student_matricule',
            'current_event_id'
        ]);

        return redirect()->route('invitation.home');
    }
}