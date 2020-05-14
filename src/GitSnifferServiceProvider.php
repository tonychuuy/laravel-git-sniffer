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

    public function boot()
    {
        $this->publishConfiguration();
    }

    /**
     * Configure config path.
     */
    protected function publishConfiguration()
    {
        $this->mergeConfigFrom($this->getConfigFileStub(), 'git-sniffer');

        $this->publishes([$this->getConfigFileStub() => $this->getConfigFile()], 'config');
    }

    /**
     * Get the config file path.
     *
     * @return string
     */
    protected function getConfigFile()
    {
        $publishPath = function_exists('config_path')
            ? config_path('git-sniffer.php')
            : base_path('config/git-sniffer.php');

        return $publishPath;
    }

    /**
     * Get the original config file.
     *
     * @return string
     */
    protected function getConfigFileStub()
    {
        return  $this->getConfigFile();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
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
