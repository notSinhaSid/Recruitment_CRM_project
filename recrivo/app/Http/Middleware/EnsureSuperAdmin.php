<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless(
            auth()->check() && auth()->user()->role->name === 'Super Admin',
            403
        );

        return $next($request);
    }
}
