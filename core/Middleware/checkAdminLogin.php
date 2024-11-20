<?php

namespace CoreMW;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Closure;
use Auth,Storage;

class checkAdminLogin
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
            if ($user->in_group > 0 && $user->active == 1 )
            {
                if (!Storage::exists('uploads/'.$user->id)) {
                    Storage::makeDirectory('uploads/'.$user->id, 0755, true);
                }
                if (!session('akayfilemanager')) {
                    $time = Carbon::now()->toArray()['timestamp'];
                    session(['akayfilemanager'=>md5($user->id.$time)]);
                }
                if ((env('SITE_CLOSURE_MODE')==1) && $user->in_group == 1) {
                    return $next($request);
                } elseif ((env('SITE_CLOSURE_MODE')==2) && $user->in_group <= 2) {
                    return $next($request);
                } elseif ((env('SITE_CLOSURE_MODE')==3) && $user->in_group > 0) {
                    return $next($request);
                } elseif ((env('SITE_CLOSURE_MODE')==0)) {
                    return $next($request);
                } else {
                    Auth::logout();
                    session()->flush();
                    $messenger = '';
                    if (env('SITE_CLOSURE_MODE')==1) {
                        $messenger = trans('Langcore::config.CloseSite1');
                    } elseif (env('SITE_CLOSURE_MODE')==2) {
                        $messenger = trans('Langcore::config.CloseSite2');
                    } elseif (env('SITE_CLOSURE_MODE')==1) {
                        $messenger = trans('Langcore::config.CloseSite3');
                    }
                    return redirect()->route('adminlogin')->with('warning', $messenger);
                }
            }
            else
            {
                Auth::logout();
                session()->flush();
                // Cache::flush();
                return redirect()->route('adminlogin');
            }
        } else {
            return redirect()->route('adminlogin');
        }
    }
}
