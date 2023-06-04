<?php

namespace AlanBlair\AT_FW_Import\Parser;

use Advanced_Themer_Bricks\AT__Class_Importer;
use AlanBlair\AT_FW_Import\App\AppController;


class ClassParser
{
    private $_url;

    private $_transient_name;

    public function __construct($url)
    {
        $this->_url = trim($url);
        $this->_transient_name = 'atfwi_url_class_' . md5($url);
    }

    public function parse()
    {
        /* Debounce multiple calls on a single page load */
        $result = get_transient($this->_transient_name);
        if ($result) {
            return $result;
        }

        if(empty($this->_url)){ return ;}

        $classes = AT__Class_Importer::extract_selectors_from_css($this->_url);
        $app = AppController::get_instance();
        if($app->get_config()['logging']){
            file_put_contents(__DIR__ . '/last-class-list', json_encode($classes, JSON_PRETTY_PRINT));
        }
        

        if(!is_array($classes)){ return [];};

        $stripped = array_map(function ($n) {
                return str_replace('.', '', $n);
            }
            , $classes
        );


        set_transient($this->_transient_name, $stripped, 5);

        return $stripped;

    }


}