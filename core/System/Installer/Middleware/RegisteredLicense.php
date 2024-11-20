<?php

namespace Installer\Middleware;

use Closure,CFglobal,AdminFunc;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;


class RegisteredLicense
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
    public function handle($request, Closure $next)
    {
        if (Cache('checklicense')['status']=='ok') {
            return $next($request);
        } else {
            return redirect()->route('installer.web.main');
        }
    }
}
