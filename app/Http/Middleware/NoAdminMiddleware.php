<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->is_admin) {
            return redirect()->route('admin.dashboard')
                ->with('toast', ['type' => 'warning', 'message' => 'Admins are not allowed on the user side.']);
        }

        return $next($request);
    }
}
