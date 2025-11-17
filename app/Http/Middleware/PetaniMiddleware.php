<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaniMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('petani')->check()) {
            return redirect()->route('petani.login');
        }

        return $next($request);
    }
}
