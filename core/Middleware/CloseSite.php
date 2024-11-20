<?php

namespace CoreMW;

use Illuminate\Http\Request;
use Closure,Auth,File;

class CloseSite
{
	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->CheckInstalled()) {
            $user = Auth::user();
            if ((env('SITE_CLOSURE_MODE')==1) && Auth::check() && $user->in_group == 1) {
                return $next($request);
            } elseif ((env('SITE_CLOSURE_MODE')==2) && Auth::check() && $user->in_group <= 2) {
                return $next($request);
            } elseif ((env('SITE_CLOSURE_MODE')==3) && Auth::check() && $user->in_group > 0) {
                return $next($request);
            } elseif ((env('SITE_CLOSURE_MODE')==0)) {
                return $next($request);
            } else {
                return redirect()->route('closesite');
            }
        } else {
            return redirect('install');
        }
    }

    public function CheckInstalled()
    {
        return file_exists(storage_path('installed'));
    }
}