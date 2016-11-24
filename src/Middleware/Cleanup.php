<?php

namespace Origami\Middleware;

use Closure;
use Auth;

use Carbon\Carbon;

use Origami\Models\Image;

class Cleanup
{

	/**
	 * Handle
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		Image::cleanup();

		return $next($request);
	}
}
