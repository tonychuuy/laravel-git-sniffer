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


    public function fire()
    {
        $environment = $this->config->get('app.env');
        $gitSnifferEnv = $this->config->get('git-sniffer.env');
        $copyPostCheckout = $this->config->get('git-sniffer.post-checkout');

        if ($environment !== $gitSnifferEnv) {
            return;
        }

        $hooksDir = base_path('.git/hooks');
        if (!$this->files->isDirectory($hooksDir)) {
            $this->files->makeDirectory($hooksDir, 0755);
        }

        $preCommitHook = $hooksDir . '/pre-commit';
        $postCheckoutHook = $hooksDir . '/post-checkout';

        $preCommitResource = $this->files->dirname(__DIR__) . '/resources/pre-commit';
        $postCheckoutResource = $this->files->dirname(__DIR__) . '/resources/post-checkout';

        if ($this->files->exists($preCommitResource)) {
            $this->files->copy($preCommitResource, $preCommitHook);
        }

        if($copyPostCheckout) {
            if ($this->files->exists($postCheckoutResource)) {
                $this->files->copy($postCheckoutResource, $postCheckoutHook);
            }
        }
    }
}
