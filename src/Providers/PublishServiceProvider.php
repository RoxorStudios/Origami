<?php

namespace Origami\Providers;

use Illuminate\Support\ServiceProvider;

class PublishServiceProvider extends ServiceProvider
{

	/**
     * Bootstrap the application services.
     *
     * @return void
     */
	public function boot()
    {
    	$this->publishes([
            __DIR__.'/../Assets/compiled' => public_path('vendor/origami'),
            __DIR__.'/../Assets/images' => public_path('vendor/origami/images'),
        ], 'public');
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