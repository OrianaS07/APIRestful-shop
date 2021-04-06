<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
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
        $request->header('Access-Control-Allow-Origin','*');
        $request->header('Access-Control-Allow-Methods','GET,POST,PUT,DELETE,OPTIONS');
        $request->header('Access-Control-Allow-Headers','X-Requested-With, Content-Type, X-Token-Auth, Authorization');
        return $next($request);
    }
}
