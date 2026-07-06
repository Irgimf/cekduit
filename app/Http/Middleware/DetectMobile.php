<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class DetectMobile
{
    public function handle(Request $request, Closure $next)
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        config(['is_mobile' => $agent->isMobile() || $agent->isTablet()]);

        return $next($request);
    }
}