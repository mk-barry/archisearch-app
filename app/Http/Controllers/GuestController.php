<?php

namespace App\Http\Controllers;
use App\Models\Events;
use App\Models\AuthorizedStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

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

    public function invitation()
    {
        return view('user.invitation');
    }
    public function identification()
    {
        return view('user.identification');
    }
    public function upload()
    {
        return view('user.televersement');
    }
    public function confirmation()
    {
        return view('user.confirmation');
    }
    public function verifyIdentification(Request $request)
    {
        $request->validate([
            'matricule' => 'required',
            'name' => 'required',
        ]);

        $student = AuthorizedStudent::where('matricule', $request->matricule)
            ->where('name', 'like', '%' . $request->name . '%')
            ->first();

        if (!$student) {
            return back()->withErrors(['auth' => 'Identification échouée. Vérifiez vos informations.']);
        }

        // On stocke l'ID en session pour "simuler" une connexion
        session(['student_id' => $student->id, 'student_name' => $student->name]);

        return redirect()->route('invitation.upload');
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
}