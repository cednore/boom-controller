<?php

namespace Boom;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;


/**
 * Boom Controller Service Provider.
 */
class BoomControllerServiceProvider extends ServiceProvider {
    /**
     * Artisan command classes to register.
     *
     * @var array
     */
    protected $commands = [
        \Boom\Console\Initialize::class,
        \Boom\Console\MakeNsp::class,
    ];

    /**
     * Route middlewares to register.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'boom.auth' => \Boom\Middleware\Authenticate::class,
        'boom.log' => \Boom\Middleware\Log::class,
    ];

    /**
     * Route middleware groups to register.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'boom' => [
            'boom.auth',
            'boom.log',
        ],
    ];

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        \Boom\Facades\Boom::class => \Boom\BoomManager::class,
        \Boom\Facades\Controller::class => \Boom\Controller::class,
    ];


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        // Load routes
        $this->mapBoomRoutes();

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        // Register route middlewares and groups
        $this->registerRouteMiddleware();

        // Register artisan commands
        $this->commands($this->commands);
    }


    /**
     * Define the boom routes.
     *
     * @return void
     */
    protected function mapBoomRoutes() {
        if (file_exists($routes = base_path('routes/boom.php'))) {
            Route::prefix(config('boom.route.prefix'))
                ->middleware(config('boom.route.middleware'))
                ->namespace(config('boom.route.namespace'))
                ->group($routes);
        }
    }

    /**
     * Register the route middlewares and groups.
     *
     * @return void
     */
    protected function registerRouteMiddleware() {
        // Register route middlewares
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // Register middleware groups
        foreach ($this->middlewareGroups as $key => $group) {
            app('router')->middlewareGroup($key, $group);
        }
    }
}
