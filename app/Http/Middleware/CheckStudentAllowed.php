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
        $event = Events::where('uuid', $request->uuid)->firstOrFail();

        if ($event->status !== 'actif') {
            abort(403, 'Événement fermé.');
        }

        if ($event->invite_type === 'particuliers') {

            $matricule = session('student_matricule');

            $authorized = $event->authorizedStudent()
                ->where('matricule', $matricule)
                ->exists();

            if (!$authorized) {
                abort(403, 'Non autorisé.');
            }
        }

        return $next($request);
    }
}
