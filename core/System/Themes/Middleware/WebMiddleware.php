<?php

namespace Vsw\Themes\Middleware;

use Closure,CFglobal,AdminFunc;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;

class WebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Theme::set(config('theme.active'));
        return $next($request);
    }
}
