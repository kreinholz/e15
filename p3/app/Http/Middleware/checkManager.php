<?php

namespace App\Http\Middleware;

use Closure;

/* Ref: https://laravel.com/docs/7.x/middleware#defining-middleware */

class checkManager
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
        if ($request->user() && $request->user()->job_title != 'Safety Oversight Manager') {
            return redirect('/');
        }
        return $next($request);
    }
}
