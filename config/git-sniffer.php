<?php

return array(

    /*
     |--------------------------------------------------------------------------
     | Laravel Git Sniffer Settings
     |--------------------------------------------------------------------------
     |
     */
    'env' => 'local',
    'phpcs_bin' => './vendor/bin/phpcs',
    'standard' => 'PSR2',

    'encoding' => 'utf-8',
    'extensions' => [
        'php'
    ],
    'ignore' => [],
    'temp' => '.tmp_staging',
);
