<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOnboarding
{
    protected array $exceptPaths = [
        'onboarding',
        'onboarding/*',
        'logout',
        'terms',
        'privacy',
        'contact',
        'legal/*',
        '_debugbar/*',
    ];

    public function handle(Request $request, Closure $next)
    {
        // Skip kalau user belum login
        if (! auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Skip kalau sudah selesai onboarding
        if ((bool) $user->onboarding_completed === true) {
            return $next($request);
        }

        // Skip kalau user admin
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Skip kalau bukan GET request
        if (! $request->isMethod('GET')) {
            return $next($request);
        }

        // Skip kalau path dikecualikan
        foreach ($this->exceptPaths as $path) {
            if ($request->is($path)) {
                return $next($request);
            }
        }

        // Semua GET request dari user yang belum onboarding → redirect
        return redirect('/onboarding');
    }
}