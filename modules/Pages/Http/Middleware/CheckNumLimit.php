<?php

namespace Modules\Pages\Http\Middleware;

use Closure,AdminFunc,CFglobal;
use Illuminate\Http\Request;
use Modules\Pages\Entities\Pages;

class CheckNumLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $pagescount = Pages::count();
        if ($pagescount <= AdminFunc::GetNumRole('Pages')) {
            return $next($request);
        } else {
            return '<div class="modal-body">'.trans('Langcore::global.ServicePackageLimit').'</div>';
        }
    }
}
