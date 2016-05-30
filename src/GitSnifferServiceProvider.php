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
        $configPath = __DIR__ . '/../config/git-sniffer.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('git-sniffer.php');
        } else {
            $publishPath = base_path('config/git-sniffer.php');
        }

        $this->publishes([$configPath => $publishPath], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/git-sniffer.php';
        $this->mergeConfigFrom($configPath, 'git-sniffer');

        $this->app['command.git-sniffer.copy'] = $this->app->share(
            function ($app) {
                return new CopyHookCommand($app['config'], $app['files']);
            }
        );

        $this->app['command.git-sniffer.check'] = $this->app->share(
            function ($app) {
                return new CodeSnifferCommand($app['config'], $app['files']);
            }
        );

        $this->commands('command.git-sniffer.copy', 'command.git-sniffer.check');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('command.git-sniffer.copy', 'command.git-sniffer.check');
    }
}
