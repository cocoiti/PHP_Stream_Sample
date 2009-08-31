<?php
require_once "Smarty/Smarty.class.php";
require_once dirname(__FILE__) . "/../Stream_Base.php";

class Stream_Smarty extends Stream_Base
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
         stream_wrapper_register('smarty', __CLASS__); 
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

    protected function getSmarty($opt)
    {   
        $smarty = new Smarty;
        $smarty->template_dir = self::$template_dir;
        $smarty->compile_dir = self::$compile_dir;
        $smarty->caching = 0;
        return $smarty;
    }

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $paths = explode('://', $path, 2);
        $this->smarty = $this->getSmarty($options);
        foreach(self::$values as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->data = $this->smarty->fetch($paths[1]);
        $this->position = 0;
        return true;
    }
 
 }
