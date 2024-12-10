<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // kalau udh login, boleh akses ke url
            return $next($request);
        } else {
            // kalau blm login, dibalikin ke halaman login
            return redirect()->route('login')->with('failed', 'Silahkan Login Terlebih Dahulu!');
        }
       
    }
}
