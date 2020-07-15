<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

include_once __DIR__ . '/../Controllers/Common.php';

class SiteTime {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {


        if(Auth::user()->level == getValueInfo('studentLevel') && !siteTime())
            return Redirect::route("home");

        return $next($request);
    }
}
