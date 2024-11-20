<?php

namespace CoreMW;

use Illuminate\Http\Request;
use Vsw\Permissions\Models\Permissions;
use Vsw\Permissions\Models\Roles;
use Vsw\Modules\Models\Modules;
use Closure,Auth,AdminFunc;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;

class CheckWebMod
{
	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$module)
    {
        return $next($request);
    }
}