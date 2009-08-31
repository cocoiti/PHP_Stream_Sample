<?php
require_once "Smarty/Smarty.class.php";
require_once dirname(__FILE__) . "/../Stream_Base.php";

class Stream_Raw extends Stream_Base
{
    private
        $smarty;
    static protected
        $values = array(),
        $template_dir = array(),
        $compile_dir = array();

    public function  __construct()
    {

    }

    public static function register()
    {
         stream_wrapper_register('raw', __CLASS__); 
    }

    public static function assign($key, $value)
    {
        self::$values[$key] = $value;
    }


    public static function setTemplateDir($path)
    {
        self::$template_dir = $path;
    }

    public static function setCompileDir($path)
    {
        self::$compile_dir = $path;
    }

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $paths = explode('://', $path, 2);
        foreach(self::$values as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->data = $paths[1];
        $this->position = 0;
        return true;
    }
 
 }
