<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
         if (!auth()->check() || !auth()->user()->isSuperuser()) {
            abort(403, 'Unauthorized. Superuser access only.');
        }
        return $next($request);
        
    // return $next($request);
    }
}
 