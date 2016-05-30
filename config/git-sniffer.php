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

    // valid file extensions to verify on phpcs
    'phpcs_extensions' => [
        'php'
    ],

    // ignore list
    'ignore' => [],

    // temp dir to staged files
    'temp' => '.tmp_staging',

    // Eslint specific config

    // full path for eslint bin
    'eslint_bin' => '',

    // eslint config file
    'eslint_config' => '',

    // valid file extensions to verify on eslint
    'eslint_extensions' => [
        'js'
    ],
);
