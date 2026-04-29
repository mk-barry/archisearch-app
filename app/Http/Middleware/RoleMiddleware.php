<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Gère une requête entrante.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Si l'utilisateur n'est pas connecté, on le renvoie au login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // On vérifie si le rôle de l'utilisateur (en base de données) 
        // correspond au rôle requis par la route
        if (Auth::user()->role !== $role) {
            abort(403, "Accès refusé : Vous n'avez pas le rôle $role.");
        }

        return $next($request);
    }
}