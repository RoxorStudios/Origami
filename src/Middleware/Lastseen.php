<?php

namespace Origami\Middleware;

use Closure;
use Auth;

use Carbon\Carbon;

class Lastseen
{
	/**
	 * Handle
	 */
	public function handle($request, Closure $next, $guard = null)
	{

		Auth::guard('origami')->user()->update(['lastseen_at' => Carbon::now()]);

		return $next($request);
	}
}
