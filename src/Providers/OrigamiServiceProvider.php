<?php

namespace Origami\Providers;

use Illuminate\Support\ServiceProvider;

class OrigamiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register('Origami\Providers\GuardServiceProvider');
        $this->app->register('Origami\Providers\ViewServiceProvider');
        $this->app->register('Origami\Providers\RouteServiceProvider');
        $this->app->register('Origami\Providers\ConsoleServiceProvider');
        $this->app->register('Origami\Providers\FacadeServiceProvider');
        $this->app->register('Origami\Providers\MiddlewareServiceProvider');
        $this->app->register('Origami\Providers\ModelBindingServiceProvider');
        $this->app->register('Origami\Providers\MigrationServiceProvider');
        $this->app->register('Origami\Providers\TranslationServiceProvider');
        $this->app->register('Origami\Providers\PublishServiceProvider');
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
