<?php

namespace Vsw\Themes\Middleware;

use Closure,CFglobal,AdminFunc;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;


class RouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string                   $themeName
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $themeName)
    {
        $themeName = ($themeName == 'theme'||$themeName=='admintheme')?CFglobal::cfn($themeName):$themeName;
        \Theme::set($themeName);
        return $next($request);
    }
}
