<?php

namespace Avirdz\LaravelGitSniffer;

use Illuminate\Support\ServiceProvider;

class GitSnifferServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/git-sniffer.php' => config_path('git-sniffer.php')
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CopyHookCommand::class,
                CodeSnifferCommand::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/git-sniffer.php',
            'git-sniffer'
        );

//        $this->app->singleton('command.git-sniffer.copy', function ($app) {
//            return new CopyHookCommand($app['config'], $app['files']);
//        });
//
//        $this->app->singleton('command.git-sniffer.check', function ($app) {
//            return new CodeSnifferCommand($app['config'], $app['files']);
//        });
//
//        $this->commands('command.git-sniffer.copy', 'command.git-sniffer.check');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
//    public function provides()
//    {
//        return array('command.git-sniffer.copy', 'command.git-sniffer.check');
//    }
}
