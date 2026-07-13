<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPremium
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->isPremium()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Fitur ini hanya untuk pengguna Premium.'], 403);
            }

            return redirect()->route('premium.upgrade')
                ->with('warning', 'Fitur ini hanya tersedia untuk pengguna Premium. Upgrade sekarang!');
        }

        return $next($request);
    }
}