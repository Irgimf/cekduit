<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOnboarding
{
    public function handle(Request $request, Closure $next)
    {
        // Skip kalau user belum login
        if (! auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Skip kalau sudah selesai onboarding
        if ($user->onboarding_completed) {
            return $next($request);
        }

        // Skip kalau user admin
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Skip kalau sedang di route onboarding itu sendiri
        if ($request->routeIs('onboarding.*')) {
            return $next($request);
        }

        // Skip kalau sedang logout atau legal pages
        if ($request->routeIs('logout') || $request->routeIs('legal.*')) {
            return $next($request);
        }

        // Skip kalau request bukan GET (POST, PATCH, DELETE tetap jalan)
        // agar form submit tidak ter-redirect
        if (! $request->isMethod('GET')) {
            return $next($request);
        }

        // Redirect ke onboarding
        return redirect()->route('onboarding.index');
    }
}