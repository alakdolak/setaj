<?php

namespace App\Http\Middleware;

use Closure;

include_once __DIR__ . '/../Controllers/Common.php';

class Nothing {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        foreach ($_POST as $key => $value)
            $_POST[$key] = translatePersian($value);

        return $next($request);
    }
}
