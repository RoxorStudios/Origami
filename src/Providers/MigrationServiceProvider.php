<?php

namespace Origami\Providers;

use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{

	/**
     * Bootstrap the application services.
     *
     * @return void
     */
	public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
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
     * Bind my information
     */
    private function bindMyInformation()
    {
    	view()->composer('*', function($view) {
            $view->withMe(Auth::guard('origami')->user());
        });
    }

    /**
     * Bind master layout
     */
    private function bindMasterLayout()
    {
    	view()->composer('origami::layouts.master', function($view){
            $view->withModules(Module::accessible()->whereDoesntHave('field')->orderBy('position', 'asc')->get());
            if(Auth::guard('origami')->user()->admin)
                $view->withCounters([
                    'users' => User::count(),
                    'modules' => Module::count(),
                ]);
        });
    }


}