<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user udah login DAN rolenya sesuai dengan yang diminta di routes
        if (auth()->check() && auth()->user()->role == $role) {
            return $next($request); // Silakan masuk
        }

        // Kalau iseng nembus beda role, tendang balik ke dasbor masing-masing
        return redirect('/dashboard')->with('error', 'Akses Ditolak! Anda tidak memiliki izin ke halaman tersebut.');
    }
}