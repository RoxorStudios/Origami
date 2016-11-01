<?php

namespace Origami\Middleware;

use Closure;
use Auth;

use Carbon\Carbon;

class Admin
{

	/**
	 * Handle
	 */
	public function handle($request, Closure $next, $guard = null)
	{

		if (!Auth::guard('origami')->user()->admin) {
            return redirect(origami_url());
        }

		return $next($request);
	}
}
