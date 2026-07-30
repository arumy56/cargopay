<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //  if (!auth()->check() || !auth()->user()->isSuperuser()) {
        //     abort(403, 'Unauthorized. Superuser access only.');
        // }
         if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // User has been deactivated
        if (!$user->is_active) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact the administrator.');
        }

        // User is logged in but is not a superuser
        if (!$user->isSuperuser()) {
            abort(403, 'Unauthorized. Superuser access only.');
        }
        return $next($request);
        
    // return $next($request);
    }
}
 