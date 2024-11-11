<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Dosen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/dosen/dashboard')->withErrors(['error' => 'You must be logged in to access this page.']);
        }

        if ($user->id_jenis_user !== 3) {
            return redirect()->back()->withErrors(['error' => 'You must be an Admin to access this page.']);
        }
        return $next($request);
    }
}
