<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Events;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentAllowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $uuid = $request->route('uuid') ?? $request->query('uuid');

        if (!$uuid) {
            dd("Le middleware ne trouve pas d'UUID. La route est : " . $request->url());
        }
        // dd($uuid);
        $event = Events::where('uuid', $uuid)->firstOrFail();

        if (!$event) {
            dd("L'UUID existe ($uuid), mais aucun événement ne correspond en base de données.");
        }

        // Si l'événement est clos, on ne bloque pas l'accès (car il peut voir son historique)
        // mais on bloquera uniquement l'action POST de stockage.

        if ($event->invite_type === 'particuliers') {
            $matricule = session('student_matricule');

            if (!$matricule) {
                return redirect()->route('invitation.identification', $uuid);
            }

            $authorized = $event->authorizedStudent()
                ->where('matricule', $matricule)
                ->exists();

            if (!$authorized) {
                abort(403, 'Vous n\'êtes pas autorisé pour cet événement.');
            }
        }

        return $next($request);
    }
}
