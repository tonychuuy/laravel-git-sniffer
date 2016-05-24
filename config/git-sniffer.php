<?php

return array(
    // run the commands only in this environment
    'env' => 'local',

    // full path for phpcs bin
    'phpcs_bin' => './vendor/bin/phpcs',

    // code standard to verify
    'standard' => 'PSR2',

    // file encoding
    'encoding' => 'utf-8',

    // valid file extensions to verify
    'extensions' => [
        'php'
    ],

    // ignore list
    'ignore' => [],

    // temp dir to staged files
    'temp' => '.tmp_staging',

    // copy also the post-checkout hook
    'post-checkout' => false,
);
