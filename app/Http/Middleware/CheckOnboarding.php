<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOnboarding
{
    // Route yang dikecualikan dari redirect onboarding
    protected array $except = [
        'onboarding*',
        'logout',
        'profile*',
        'legal*',
    ];

    public function handle(Request $request, Closure $next)
    {
        if (
            auth()->check()
            && ! auth()->user()->onboarding_completed
            && ! auth()->user()->isAdmin()
            && ! $this->isExcluded($request)
        ) {
            return redirect()->route('onboarding.index');
        }

        return $next($request);
    }

    private function isExcluded(Request $request): bool
    {
        foreach ($this->except as $pattern) {
            if ($request->routeIs($pattern)) {
                return true;
            }
        }
        return false;
    }
}