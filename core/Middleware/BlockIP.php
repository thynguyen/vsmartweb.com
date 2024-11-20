<?php

namespace CoreMW;

use Closure;

class BlockIP
{
    // set IP addresses
    public $restrictIps = ['ip-addr-0', 'ip-addr-1', '127.0.0.5'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array($request->ip(), $this->restrictIps)) {
            return response()->json(['message' => "You don't valid Ip Address"]);
        }

        return $next($request);
    }
}