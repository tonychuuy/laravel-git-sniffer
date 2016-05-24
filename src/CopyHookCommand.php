<?php

namespace Avirdz\LaravelGitSniffer;

use Illuminate\Console\Command;

class CopyHookCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'git-sniffer:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy the git hooks scripts to hooks directory';
    protected $config;

    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }


    public function fire()
    {
        $environment = $this->config->get('app.env');
        $gitSnifferEnv = $this->config->get('git-sniffer.env');

        if ($environment !== $gitSnifferEnv) {
            return;
        }


    }
}
