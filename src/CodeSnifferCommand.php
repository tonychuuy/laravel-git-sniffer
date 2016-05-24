<?php

namespace Avirdz\LaravelGitSniffer;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CodeSnifferCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'git-sniffer:phpcs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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

        if ($environment !== $gitSnifferEnv) {
            return;
        }

        $phpcsBin = $this->config->get('git-sniffer.phpcs_bin');

        if (!$this->files->exists($phpcsBin)) {
            $this->error('PHP CodeSniffer bin not found');
            exit(1);
        }

        $revision = trim(shell_exec('git rev-parse --verify HEAD'));
        $against = "4b825dc642cb6eb9a060e54bf8d69288fbee4904";
        if (!empty($revision)) {
            $against = 'HEAD';
        }

        //this is the magic:
        //retrieve all files in staging area that are added, modified or renamed
        //but no deletions etc
        $files = trim(shell_exec("git diff-index --name-only --cached --diff-filter=ACMR {$against} --"));
        if (empty($files)) {
            exit(0);
        }

        $tempStaging = $this->config->get('git-sniffer.temp');
        //create temporary copy of staging area
        if ($this->files->exists($tempStaging)) {
            $this->files->deleteDirectory($tempStaging);
        }

        $fileList = explode("\n", $files);
        $validExtensions = $this->config->get('git-sniffer.extensions');
        $validFiles = [];

        foreach ($fileList as $l) {
            if (in_array($this->files->extension($l), $validExtensions)) {
                $validFiles[] = $l;
            }
        }

        //Copy contents of staged version of files to temporary staging area
        //because we only want the staged version that will be commited and not
        //the version in the working directory
        if (empty($validFiles)) {
            exit(0);
        }

        $this->files->makeDirectory($tempStaging);
        $staged = [];
        foreach ($validFiles as $f) {
            $id = shell_exec("git diff-index --cached {$against} \"{$f}\" | cut -d \" \" -f4");
            if (!$this->files->exists($tempStaging . '/' . $this->files->dirname($f))) {
                $this->files->makeDirectory($tempStaging . '/' . $this->files->dirname($f), 0755, true);
            }
            $output = shell_exec("git cat-file blob {$id}");
            $this->files->put($tempStaging . '/' . $f, $output);
            $staged[] = '"' . $tempStaging . '/' . $f . '"';
        }
        $sniffFiles = implode(' ', $staged);

        $standard = $this->config->get('git-sniffer.standard');
        $encoding = $this->config->get('git-sniffer.encoding');
        $phpcsOutput = shell_exec("\"{$phpcsBin}\" -s --standard={$standard} --encoding={$encoding} {$sniffFiles}");
        $this->files->deleteDirectory($tempStaging);

        if (empty($phpcsOutput)) {
            exit(0);
        } else {
            $this->error($phpcsOutput);
            exit(1);
        }
    }
}
