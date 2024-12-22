<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WargaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'warga') {
            return redirect()->route('login');
        }
        return $next($request);
    }
}