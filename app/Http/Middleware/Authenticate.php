<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route(self::get_guard().'.home');
        }
    }

    protected function get_guard(){
        if(Auth::guard('user')->check())
            return "user";
        elseif(Auth::guard('vet')->check())
            return "vet";
        elseif(Auth::guard('shop')->check())
            return "shop";
    }
}
