<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !($user instanceof User && $user->hasRole('admin', 'web'))) {
            // Redirect non-admins or unauthenticated users to the user dashboard
            return redirect('/dashboard')->with('error', 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
