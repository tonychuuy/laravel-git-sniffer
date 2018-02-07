<?php

namespace Avirdz\LaravelGitSniffer;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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

    /** @var Filesystem */
    protected $files;

    public function __construct($config, Filesystem $files)
    {
        parent::__construct();
        $this->config = $config;
        $this->files = $files;
    }


    public function handle()
    {
        $environment = $this->config->get('app.env');
        $gitSnifferEnv = $this->config->get('git-sniffer.env');

        if ($environment !== $gitSnifferEnv) {
            exit(0);
        }

        $this->files->makeDirectory(base_path('.git/hooks'), 0755, true);

        $stub = $this->files->get(__DIR__ . '/..resources/pre-commit');

        $preCommitContents = str_replace(
            '%COMMAND%',
            $this->config->get('git-sniffer.precommit_command', 'php artisan git-sniffer:check'),
            $stub
        );

        $this->files->put(base_path('.git/hooks/pre-commit'), $preCommitContents);
    }
}
