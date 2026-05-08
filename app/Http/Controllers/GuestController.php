<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\AuthorizedStudent;
use Illuminate\Support\Facades\DB;
use App\Models\Documents;
use Illuminate\Http\Request;

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

    public function storeDocument(Request $request, $uuid)
    {
        $event = Events::where('uuid', $uuid)->firstOrFail();

        // Vérification de sécurité
        if (now()->gt($event->end_date) || $event->status === 'cloturé') {
            return back()->with('error', 'Événement clôturé.');
        }

        // Validation du fichier
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:' . $event->max_file_size * 1024, // Converti Mo en Ko
            'document_type' => 'required|string'
        ]);

        $file = $request->file('document');
        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $path = $file->store('documents/' . session('student_matricule'));

        // Sauvegarde en base
        Documents::create([
            'event_id' => $event->id,
            'identifier' => session('student_matricule'),
            'original_name' => $originalName,
            'file_size' => $fileSize,
            'path' => $path,
            'type_document' => $request->document_type
        ]);

        return back()->with('success', 'Document bien enregistré.');
    }
    // public function confirmation()
    // {
    //     return view('user.confirmation');
    // }
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

        // // On stocke en session (attention à bien utiliser fullname ici)
        // session([
        //     'student_id' => $student->id,
        //     'student_name' => $request->fullname,
        //     'student_matricule' => $student->matricule,
        //     'current_event_id' => $request->event_id // Stocké pour le téléversement
        // ]);

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
    // public function confirmation()
    // {
    //     // Vérifie si l'utilisateur est connecté
    //     if (!Auth::check()) {
    //         // Redirige vers la page de connexion en spécifiant la route de destination
    //         return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette page.');
    //     }

    //     // On récupère l'utilisateur connecté
    //     $user = Auth::user();

    //     // On récupère les événements en attente de l'utilisateur connecté
    //     $pendingEvents = Events::where('user_id', $user->id)
    //         ->where('status', 'en_attente')
    //         ->get();

    //     // On injecte les données dans la vue
    //     return view('user.confirmation', compact('pendingEvents'));
    // }

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