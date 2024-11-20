<?php

namespace CoreMW;

use Illuminate\Http\Request;
use Vsw\Permissions\Models\Permissions;
use Vsw\Permissions\Models\Roles;
use Vsw\Modules\Models\Modules;
use Closure,Auth,AdminFunc;

class CheckMod
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
        if (AdminFunc::ReturnModule($module,'active')==1) {
            $user = Auth::user();
            if ($user->in_group<=2) {
                return $next($request);
            } else {
                $pathmod = AdminFunc::ReturnModule($module,'pathmod');
                $rolemodule = Roles::where('per_id',$user->in_group)->pluck('modules');
                $modules = [];
                foreach ($rolemodule as $value) {
                  $modules[]= $value;
                }
                if ($user->in_group>2 && in_array($pathmod, $modules)) {
                    return $next($request);
                } else {
                    return redirect()->back();
                }
            }
        } else {
            return redirect()->route('dashboard');
        }
    }
}