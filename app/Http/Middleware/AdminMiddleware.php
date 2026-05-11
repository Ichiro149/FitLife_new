<?php

/**
 * Šī starpprogrammatūra kontrolē "Admin Middleware" piekļuvi vai pieprasījuma apstrādi.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || ! in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
