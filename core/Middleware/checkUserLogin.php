<?php

namespace CoreMW;

use Illuminate\Http\Request;
use Closure;
use Auth;

class checkUserLogin
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
        if (Auth::check())
        {
            $user = Auth::user();
            if ($user->active == 1 )
            {
                return $next($request);
            }
            else
            {
                Auth::logout();
                return redirect()->route('members.web.main');
            }
        } else
            return redirect()->route('members.web.main');
    }
}
