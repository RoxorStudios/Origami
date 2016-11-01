<?php

namespace Origami\Providers;

use Illuminate\Support\ServiceProvider;

use Auth;
use Origami\Models\User;
use Origami\Models\Module;
use Origami\Models\Image;

class OrigamiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->initMigrations();
        $this->initRoutes();
        $this->initViews();
        $this->initPublications();
        $this->initModelBindings();
        //$this->initHousekeeping();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->initConsole();
        $this->initMiddleware();
        $this->initFacades();
    }

    /**
     * Init migrations
     */
    private function initMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
    }

    /**
     * Init routes
     */
    private function initRoutes()
    {
        $this->app->router->group(['namespace' => 'Origami\Controllers'], function(){
            if (! $this->app->routesAreCached()) {
                require __DIR__.'/../Routes/web.php';
            }
        });
    }

    /**
     * Init migrations
     */
    private function initViews()
    {
        $this->loadViewsFrom(__DIR__.'/../Views', 'origami');

        view()->composer('*', function($view) {
            $view->withMe(Auth::guard('origami')->user());
        });
        view()->composer('origami::layouts.master', function($view){
            $view->withModules(Module::accessible()->orderBy('position', 'asc')->get(['uid','name']));
            if(Auth::guard('origami')->user()->admin)
                $view->withCounters([
                    'users' => User::count(),
                    'modules' => Module::count(),
                ]);
        });
    }

    /**
     * Init publications
     */
    private function initPublications()
    {
        $this->publishes([
            __DIR__.'/../Assets/compiled' => public_path('vendor/origami'),
            __DIR__.'/../Assets/images' => public_path('vendor/origami/images'),
        ], 'public');
    }

    /**
     * Init console
     */
    private function initConsole()
    {
        $this->commands([
            \Origami\Console\InstallCMS::class,
        ]);
    }

    /**
     * Init middleware
     */
    private function initMiddleware()
    {
        $this->app['router']->middleware('origami_auth', 'Origami\Middleware\Authentication');
        $this->app['router']->middleware('origami_lastseen', 'Origami\Middleware\Lastseen');
        $this->app['router']->middleware('origami_admin', 'Origami\Middleware\Admin');
    }

    /**
     * Init model bindings
     */
    private function initModelBindings()
    {
        $this->bindModel('user', 'users');
        $this->bindAccessibleModel('module', 'modules');
        $this->bindModel('field', 'modules');
        $this->bindModel('entry', 'modules');
    }

    /**
     * Init Facades
     */
    private function initFacades()
    {
        $this->app->bind('origami', function() { return new \Origami\Api\Origami; });
    }

    /**
     * Init housekeeping
     */
    private function initHousekeeping()
    {
        Image::cleanup();
    }

    /**
     * Bind model
     */
    private function bindModel($type, $fallbackUrl)
    {
        $this->app['router']->bind($type, function ($value) use ($type, $fallbackUrl) {
            $model = '\Origami\\Models\\'.ucfirst($type);
            $eloquent = new $model;
            if(!$instance = $eloquent->where('uid', $value)->first() ? : null) redirect(origami_url('/'.$fallbackUrl))->send();
            return $instance ;
        });
    }

    /**
     * Bind model with accessible scope
     */
    private function bindAccessibleModel($type, $fallbackUrl)
    {
        $this->app['router']->bind($type, function ($value) use ($type, $fallbackUrl) {
            $model = '\Origami\\Models\\'.ucfirst($type);
            $eloquent = new $model;
            if(!$instance = $eloquent->where('uid', $value)->accessible()->first() ? : null) redirect(origami_url('/'.$fallbackUrl))->send();
            return $instance ;
        });
    }

    
}
