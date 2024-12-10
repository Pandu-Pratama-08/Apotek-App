<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsKasir
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role == "kasir" || Auth::user()->role == "admin"){
            return $next($request);
        } else {
            return redirect()->route('landing_page')->with('failed', 'Anda bukan admin! tidak diperbolehkan untuk akses');
        }
    }
}
