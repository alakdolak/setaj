<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminAccess {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        include_once __DIR__ . '/../Controllers/Common.php';

        if(Auth::user()->level == getValueInfo('adminLevel'))
            return $next($request);

        return Redirect::route('profile');
    }
}
