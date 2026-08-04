<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBillerSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = auth()->user();

        // Only enforce this on superusers
        if ($user && $user->isSuperuser()) {
            // Check if biller account exists AND is_completed is true
            if (! $user->billerAccount || ! $user->billerAccount->is_completed) {
                return redirect()->route('dashboard.index')
                    ->with('openBillerDialog', true)
                    ->with('warning', 'Please set up your Biller Account to unlock organization features.');
            }
        }

        return $next($request);
    }
}
