<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EspaceMembre
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
        $coockie = $request->cookie('espace_utlisateur');
        $session = session('espace_utlisateur');

        if ($coockie) {
            return $next($request);
        } elseif ($session) {
            return $next($request);
        }

        return redirect(config('app.front_office'));
    }
}
