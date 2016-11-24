<?php

namespace Origami\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

	/**
     * Bootstrap the application services.
     *
     * @return void
     */
	public function boot()
    {
    	$this->app->router->group(['namespace' => 'Origami\Controllers'], function(){
            if (! $this->app->routesAreCached()) {
                require __DIR__.'/../Routes/routes.php';
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

}