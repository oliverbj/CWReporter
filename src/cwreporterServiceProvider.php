<?php

namespace oliverbj\cwreporter;

use Illuminate\Support\ServiceProvider;
use oliverbj\cwreporter\Facades\cwreporter;
use Illuminate\Routing\Router;
use oliverbj\cwreporter\Consoles\ProcessReports;

class cwreporterServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'oliverbj');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'cwreporter');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // use this if your package has routes
        $this->setupRoutes($this->app->router);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            // Publishing the configuration file.
            $this->publishes([
<<<<<<< HEAD
                __DIR__ . '/../config/cwreporter.php' => config_path('cwreporter.php'),
            ], 'cwreporter.config');
=======
                __DIR__ . '/config/cwreporter.php' => config_path('cwreporter.php'),
            ], 'cwreporter');
>>>>>>> 5a575d63ec577cb7a62d46e1dbd804b8b5077518

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/oliverbj'),
            ], 'cwreporter.views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/oliverbj'),
            ], 'cwreporter.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/oliverbj'),
            ], 'cwreporter.views');*/

            // Registering package commands.
            $this->commands([
                ProcessReports::class
            ]);
        }
    }

    /**
<<<<<<< HEAD
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'oliverbj\cwreporter\Http\Controllers'], function ($router) {
            require __DIR__ . '/Http/routes.php';
        });
    }

    /**
=======
>>>>>>> 5a575d63ec577cb7a62d46e1dbd804b8b5077518
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
<<<<<<< HEAD
        $this->mergeConfigFrom(__DIR__ . '/../config/cwreporter.php', 'cwreporter');
=======
        $this->mergeConfigFrom(__DIR__ . '/config/cwreporter.php', 'cwreporter');
>>>>>>> 5a575d63ec577cb7a62d46e1dbd804b8b5077518

        // Register the service the package provides.
        $this->app->singleton('cwreporter', function ($app) {
            return new cwreporter;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['cwreporter'];
    }
<<<<<<< HEAD
=======

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'oliverbj\cwreporter\Http\Controllers'], function ($router) {
            require __DIR__ . '/Http/routes.php';
        });
    }
>>>>>>> 5a575d63ec577cb7a62d46e1dbd804b8b5077518
}
