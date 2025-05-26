<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request                    $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null                                  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        if (! Auth::check()) {
            // Jika belum login, arahkan ke halaman login
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Jika parameter $role disetel dan user->role tidak cocok,
        // kembalikan ke halaman home (atau abort 403 sesuai kebutuhan).
        if ($role && $userRole !== $role) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
