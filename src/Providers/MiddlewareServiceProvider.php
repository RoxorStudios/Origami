<?php

namespace Origami\Providers;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{

	/**
     * Bootstrap the application services.
     *
     * @return void
     */
	public function boot()
    {
    	
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->middleware('origami_check_installation', 'Origami\Middleware\CheckInstallation');
        $this->app['router']->middleware('origami_auth', 'Origami\Middleware\Authentication');
        $this->app['router']->middleware('origami_lastseen', 'Origami\Middleware\Lastseen');
        $this->app['router']->middleware('origami_admin', 'Origami\Middleware\Admin');
        $this->app['router']->middleware('origami_cleanup', 'Origami\Middleware\Cleanup');
    }

}