<?php

namespace Origami\Providers;

use Illuminate\Support\ServiceProvider;

use Origami\Models\User;

class GuardServiceProvider extends ServiceProvider
{

	/**
     * Bootstrap the application services.
     *
     * @return void
     */
	public function boot()
    {
    	$this->addGuard();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Add custom guard
     */
    private function addGuard()
    {
        config(['auth.guards' => array_merge(
            config('auth.guards'),
            [
                'origami'=> [
                    'driver' => 'session',
                    'provider' =>'origami_users',
                ]
            ])
        ]);

        config(['auth.providers' => array_merge(
            config('auth.providers'),
            [
                'origami_users' => [
                    'driver' => 'eloquent',
                    'model' => User::class,
                ]
            ])
        ]);
    }
}