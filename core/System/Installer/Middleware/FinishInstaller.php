<?php

namespace Installer\Middleware;

use Closure,CFglobal,AdminFunc;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;


class FinishInstaller
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
        if (!$this->CheckInstalled()) {
            return $next($request);
        } else {
            return redirect()->route('indexhome');
        }
    }
    public function CheckInstalled()
    {
        return file_exists(storage_path('installed'));
    }
}
