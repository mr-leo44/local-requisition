<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $connected_user = Session::get('authUser');
        if ($connected_user !== null) {
            if ($connected_user->compte->role->value === 'admin') {
                return redirect()->route('users.index');
            } else {
                return redirect()->route('demandes.index');
            }
        } else {
            return $next($request);
        }
        return $next($request);
    }
}
