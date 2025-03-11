<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
        if (!$request->user() || !$request->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé. Seuls les administrateurs peuvent accéder à cette page.');
        }

        return $next($request);
    }
}
