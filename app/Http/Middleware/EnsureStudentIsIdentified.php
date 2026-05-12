<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentIsIdentified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $uuid = $request->route('uuid') ?? $request->query('uuid');

        // Si l'étudiant n'a pas son ID ou son Matricule en session, on le renvoie à l'accueil
        if (!session()->has('student_id') || !session()->has('student_matricule')) {
            return redirect()->route('invitation.identification', $uuid)
                ->with('error', 'Veuillez vous identifier pour accéder au dépôt.');
        }

        return $next($request);
    }
}
