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
     * Console commands to be instantiated.
     *
     * @var array
     */
    protected $commandList = [
        'command.git-sniffer.copy' => CopyHookCommand::class,
        'command.git-sniffer.check' => CodeSnifferCommand::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishConfiguration();

        $this->registerCommands();
    }

    /**
     * Configure config path.
     */
    protected function publishConfiguration()
    {
        $configPath = __DIR__ . '/../config/git-sniffer.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('git-sniffer.php');
        } else {
            $publishPath = base_path('config/git-sniffer.php');
        }
        $this->mergeConfigFrom($configPath, 'git-sniffer');
        $this->publishes([$configPath => $publishPath], 'config');
    }

    /**
     * Register command.
     *
     * @param $name
     * @param $commandClass string
     */
    protected function registerCommand($name, $commandClass)
    {
        $this->app->singleton($name, function ($app) use ($commandClass) {
            return new $commandClass($app['config'], $app['files']);
        });
        $this->commands($name);
    }

    /**
     * Register Artisan commands.
     */
    protected function registerCommands()
    {
        collect($this->commandList)->each(function ($commandClass, $key) {
            $this->registerCommand($key, $commandClass);
        });
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
