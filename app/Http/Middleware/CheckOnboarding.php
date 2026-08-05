<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOnboarding
{
    // Path yang dikecualikan
    protected array $exceptPaths = [
        'onboarding',
        'onboarding/*',
        'logout',
        'terms',
        'privacy',
        'contact',
        'legal/*',
    ];

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

        // Skip kalau path dikecualikan
        if ($this->isExcluded($request)) {
            return $next($request);
        }

        // Hanya redirect untuk GET request
        if (! $request->isMethod('GET')) {
            return $next($request);
        }

        // Redirect ke onboarding
        return redirect('/onboarding');
    }

    private function isExcluded(Request $request): bool
    {
        foreach ($this->exceptPaths as $path) {
            if ($request->is($path)) {
                return true;
            }
        }
        return false;
    }
}