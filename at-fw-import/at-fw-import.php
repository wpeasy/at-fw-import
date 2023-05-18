<?php
/**
 * Plugin Name: Advanced Themer Framework Importer
 * Plugin URI: https://www.wpeasy.au
 * Description: This is a plugin to import Advanced Themer Framework variables and classes.
 * Version: 1.0.2
 * Author: Alan Blair
 * Author URI: https://www.wpeasy.au
 * License: GPL2
 * Text Domain: at-fw-import
 */
// If this file is called directly, abort.
use AlanBlair\AT_FW_Import\Parser\ClassParser;
use AlanBlair\AT_FW_Import\Parser\VariableParser;

if (!defined('WPINC')) { die; }


require_once __DIR__ .'/vendor/autoload.php';

$app = \AlanBlair\AT_FW_Import\App\AppController::get_instance(require __DIR__ . '/config.php')
    ->run();


add_action('plugins_loaded', function() use ($app){

    add_filter('at/css_var_framework/import_vars', function ($value) {
        $urls = get_option('atfwi_urls');
        if(false === $urls){ return $value;}

        $urlsArrar= explode("\n", $urls);
        if(! is_array($value)){ $value = []; };
        $parsed = [];

        foreach ($urlsArrar as $urlsString ){
            $p = new VariableParser($urlsString);
            $parsed = array_merge($parsed, $p->parse());
        }

        return array_merge($value, $parsed);
    });

    add_filter('at/imported_classes/import_classes', function ($value) {
        $urls = get_option('atfwi_urls');
        if(false === $urls){ return $value;}

        $urlsArrar= explode("\n", $urls);
        if(! is_array($value)){ $value = []; };

        $parsed = [];
        foreach ($urlsArrar as $urlsString ){
            $p = new ClassParser($urlsString);
            $parsed = array_merge($parsed, $p->parse());
        }

        return array_merge($value, $parsed);
    });
});

