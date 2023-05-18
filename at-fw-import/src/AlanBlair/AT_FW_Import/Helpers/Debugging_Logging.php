<?php

namespace AlanBlair\AT_FW_Import\Helpers;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class Debugging_Logging
{
    private $_debug_enabled;
    private $_log_enabled;
    private $_log_path;

    /*@var $_log_instance Logger */
    private $_log_instance;

    private static $_instance;
    public static function get_instance($debug = null, $logging = null, $log_path = null)
    {
        if(!self::$_instance){ self::$_instance = new self(); }
        if(null !== $debug){ self::$_instance->_debug_enabled = $debug; }
        if(null !== $logging){ self::$_instance->_log_enabled = $logging; }
        if(null !== $log_path){ self::$_instance->_log_path = $log_path; }
        self::$_instance->_init();
        return self::$_instance;
    }


    public function __construct()
    {
    }

    private function _init()
    {
        if($this->_log_enabled){
            $log = new Logger('atfwi');
            $log_rotate = new RotatingFileHandler($this->_log_path . 'at-fw-import.log', 10);
            $log->pushHandler($log_rotate);
            $this->_log_instance = $log;
        }
    }


    public function error($message){
        $this->_log_instance->error($message);
    }

    public function warn($message){
        $this->_log_instance->warn($message);
    }

    public function info($message){
        $this->_log_instance->info($message);
    }

    public function debug($message){
        $this->_log_instance->debug($message);
    }

}