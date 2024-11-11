<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Guest
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect('/')->withErrors(['error' => 'You must be logged in to access this page.']);
        }

        if ($user->id_jenis_user !== 2) {
            return redirect('/')->withErrors(['error' => 'You must be an Admin to access this page.']);
        }
        return $next($request);
    }
}
