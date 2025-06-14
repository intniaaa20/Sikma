<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DenyCustomerOnFilament
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole('customer')) {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}
