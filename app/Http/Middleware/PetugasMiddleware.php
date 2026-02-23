<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PetugasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'petugas') {
            return redirect('/login')->with('error', 'Akses ditolak. Hanya petugas yang bisa masuk.');
        }

        return $next($request);
    }
}
