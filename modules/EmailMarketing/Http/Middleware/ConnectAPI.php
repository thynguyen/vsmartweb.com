<?php

namespace Modules\EmailMarketing\Http\Middleware;

use Closure,Newsletter;
use Illuminate\Http\Request;

class ConnectAPI
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
        if (Newsletter::getApi()->get('ping') == false) {
            $data = [];
            return FileViewTheme('EmailMarketing','apinotconnect',$data,'admin');
        } else {
            return $next($request);
        }
    }
}
