<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Vérifier si l'utilisateur est connecté
        if (!$request->user()) {
            return redirect()->route('login');
        }
        
        // Vérifier si l'utilisateur a le rôle admin (vérification insensible à la casse)
        if (!$request->user()->hasRole('Admin')) {
            abort(403, 'Accès non autorisé. Seuls les administrateurs peuvent accéder à cette page.');
        }
        
        return $next($request);
    }
}
