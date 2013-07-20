<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SysAutoload
 *
 * @author ishibkikh
 */
class SysAutoload
{
    public static $loader;
    
    public static function init()
    {
        if (self::$loader == NULL)
            self::$loader = new self();

        return self::$loader;
    }
    
    public function __construct()
    {
        spl_autoload_register(array($this,'autoload'));
    }
    
    public function autoload($class)
    {
        $file = PATH.'components/'.$class.'.php';
        if (!file_exists($file))
        {
            $file = PATH.'core/'.$class.'.php';
            if (!file_exists($file))
            {
                $file = PATH.'application/models/'.$class.'.php';
                WebApp::checkPath($file);
            }
        }   
        //set_include_path(PATH.'components/');
        //spl_autoload_extensions('.com.php');
        //spl_autoload($file);
        require_once $file;
    }
}

?>
