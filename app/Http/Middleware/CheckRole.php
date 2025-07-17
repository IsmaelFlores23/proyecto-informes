<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('login');
        }
        
        // Verificar si el usuario tiene alguno de los roles requeridos
        $userRole = Auth::user()->role()->first()->nombre_role ?? null;
        
        if (!in_array($userRole, $roles)) {
            // Redirigir a una página de acceso denegado o al dashboard
            return redirect('dashboard')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        
        return $next($request);
    }
}