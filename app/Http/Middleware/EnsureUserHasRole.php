<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(Session::get('authUser') === null){
            return redirect()->route('login');
        }

        $user = Session::get('authUser');
        if(in_array('not-admin', $roles) && $user->compte->role->value === 'admin'){
            return response()->view('errors.403', [], 403);
        }
        if(in_array($user->compte->role->value , $roles)){
            return $next($request);
        }
        return response()->view('errors.403', [], 403);
    }
}
