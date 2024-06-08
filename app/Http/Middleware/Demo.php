<?php

namespace App\Http\Middleware;

use Closure;

class Demo
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
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE')){
            $alert = ['info', 'You can not change anything over this demo. This version is for demonstration purposes only and few actions are blocked.'];
            return back()->withAlert($alert);

        }
        return $next($request);
    }
}
