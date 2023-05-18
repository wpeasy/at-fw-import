<?php
namespace AlanBlair\AT_FW_Import\App;

use AlanBlair\AT_FW_Import\Helpers\Debugging_Logging;


class AppController
{
    private $_config;

    public $logger;

    private static $_instance;

    /**
     * @param $config
     * @return AppController
     */
    public static function get_instance( $config = null)
    {
        if(!self::$_instance){ self::$_instance = new self(); }
        if($config){ self::$_instance->set_config($config); }
        return self::$_instance;
    }

    public function __construct()
    {

    }

    /**
     * @return void
     */
    public function run()
    {
        $this->logger = Debugging_Logging::get_instance($this->_config['debug'],$this->_config['logging'], $this->_config['log_path'] . '/atfwi/');
        Settings::get_instance();
        return self::$_instance;
    }

    /**
     * @param mixed $config
     * @return AppController
     */
    public function set_config($config)
    {
        $this->_config = $config;
        return $this;
    }

    /**
     * @return mixed
     */
    public function get_config()
    {
        return $this->_config;
    }

}