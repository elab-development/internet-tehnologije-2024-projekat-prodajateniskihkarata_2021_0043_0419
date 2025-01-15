<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Korisnik nije ulogovan.'], 401);
        }

        return $next($request);
    }
    protected function redirectTo(Request $request)
    {
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Korisnik nije ulogovan.'], 401);
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Niste ovlašćeni za pristup ovoj akciji.'], 401);
        }

        abort(401, 'Niste ovlašćeni za pristup.');
    }


}