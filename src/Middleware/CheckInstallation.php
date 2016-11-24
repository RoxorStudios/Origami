<?php

namespace Origami\Middleware;

use Closure;
use Auth;
use Schema;

use Carbon\Carbon;

use Origami\Models\Settings;

class CheckInstallation
{

	/**
	 * Handle
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if(!Schema::hasTable('origami_users')) {
			return redirect(origami_url('/welcome'));
		}

		if(Settings::get('version') != origami_version()) {
			return redirect(origami_url('/welcome'));
		}


		return $next($request);
	}
}
