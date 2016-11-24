<?php

namespace Origami\Providers;

use Illuminate\Support\ServiceProvider;

use Origami\Models\User;
use Origami\Models\Module;
use Origami\Models\Field;
use Origami\Models\Entry;

class ModelBindingServiceProvider extends ServiceProvider
{

	/**
     * Bootstrap the application services.
     *
     * @return void
     */
	public function boot()
    {
        // User
    	$this->app['router']->bind('user', function ($value) {
            if(!$instance = User::where('uid', $value)->first() ? : null) redirect(origami_url('/users'))->send();
            return $instance;
        });

        // Module
        $this->app['router']->bind('module', function ($value) {
            if(!$instance = Module::where('uid', $value)->accessible()->first() ? : null) redirect(origami_url('/modules'))->send();
            return $instance;
        });

        // Field
        $this->app['router']->bind('field', function ($value) {
            if(!$instance = Field::where('uid', $value)->first() ? : null) redirect(origami_url('/modules'))->send();
            return $instance;
        });

        // Entry
        $this->app['router']->bind('entry', function ($value) {
            if(!$instance = Entry::where('uid', $value)->first() ? : null) redirect(origami_url('/modules'))->send();
            return $instance;
        });

        // Submodule
        $this->app['router']->bind('Submodule', function ($value) {
            dd('ok');
            dd(Field::where('uid',$value)->first());
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