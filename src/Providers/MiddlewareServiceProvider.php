<?php

namespace Origami\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{

	/**
     * Bootstrap the application services.
     *
     * @return void
     */
	public function boot(Router $router)
    {
		//$router->middleware('origami_check_installation', 'Origami\Middleware\CheckInstallation');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
		$this->registerMiddleware('origami_check_installation', 'Origami\Middleware\CheckInstallation');
		$this->registerMiddleware('origami_auth', 'Origami\Middleware\Authentication');
		$this->registerMiddleware('origami_lastseen', 'Origami\Middleware\Lastseen');
		$this->registerMiddleware('origami_admin', 'Origami\Middleware\Admin');
		$this->registerMiddleware('origami_cleanup', 'Origami\Middleware\Cleanup');
    }

	/**
	 * Register middleware
	 *
	 * @return void
	 */
	private function registerMiddleware($alias, $class)
	{
		return method_exists($this->app['router'], 'aliasMiddleware') ? $this->app['router']->aliasMiddleware($alias, $class) : $this->app['router']->middleware($alias, $class);
	}

}
