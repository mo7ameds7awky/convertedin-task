<?php

namespace App\Http\Middleware;

use App\Support\UserSupport;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && ! UserSupport::isAdmin(Auth::user())) {
            abort(403);
        }

        return $next($request);
    }
}
