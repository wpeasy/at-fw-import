<?php

return [
    'debug' => true, /* May require BugFu */
    'logging' => true,
    'file' => __FILE__,
    'dir' => __DIR__,
    'url' => plugin_dir_url(__FILE__) . '/',
    'log_path' => __DIR__ . '/log',

    'plugin_name' => 'Advanced Themer Framework Importer',
    'plugin_short_name' => 'AT FW Import',
    'plugin_description' => 'This plugin parses the entered URLs to variables for Advanced Themer, and classes to Bricks Builder.',
    'text-domain' => 'at-fw-import'
];
