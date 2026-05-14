<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BuyerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow both buyers and sellers to access the marketplace/buyer dashboard
        if (Auth::check() && in_array(Auth::user()->role, ['buyer', 'seller'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
