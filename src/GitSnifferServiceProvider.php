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
                return new CopyHookCommand($app['config']);
            }
        );

        $this->commands('command.git-sniffer.copy');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('command.git-sniffer.copy');
    }
}
