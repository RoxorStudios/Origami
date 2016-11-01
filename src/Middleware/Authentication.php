<?php

namespace Origami\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authentication
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
	    if (!Auth::guard('origami')->check()) {
	        return redirect(origami_url('/login'));
	    }

	    return $next($request);
	}
}