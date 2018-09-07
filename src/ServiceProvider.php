<?php

namespace TrafficSupply\Sessions;

use Illuminate\Contracts\Http\Kernel;
use TrafficSupply\Sessions\Middleware\InjectJavascript;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/trafficsupply.sessions.php';
        $this->mergeConfigFrom($configPath, 'trafficsupply.sessions');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerConfig();

        $this->registerRoutes();

        $this->registerViews();

        $this->registerMiddleware(InjectJavascript::class);
    }

    /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('trafficsupply.sessions.php');
    }

    protected function registerConfig()
    {
        $configPath = __DIR__ . '/../config/trafficsupply.sessions.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'sessions');
    }

    protected function registerRoutes()
    {
        $routeConfig = [
            'namespace' => 'TrafficSupply\Sessions\Controllers',
            'domain' => $this->app['config']->get('trafficsupply.sessions.master_domain.route_domain'),
            'middleware' => 'web',
        ];

        $this->getRouter()->group($routeConfig, function($router) {
            $router->get($this->app['config']->get('trafficsupply.sessions.get_url'), [
                'uses' => 'SessionsController@getTSId',
                'as' => 'trafficsupply.sessions.get_ts_id'
            ]);
        });

        unset($routeConfig['domain']);

        $this->getRouter()->group($routeConfig, function($router) {
            $router->post($this->app['config']->get('trafficsupply.sessions.set_url'), [
                'uses' => 'SessionsController@setTSId',
                'as' => 'trafficsupply.sessions.set_ts_id'
            ]);
        });
    }

    /**
     * Register the Debugbar Middleware
     *
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $this->app['router']->aliasMiddleware('sessions', InjectJavascript::class);
    }
}
