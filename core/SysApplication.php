<?php

/*
 * Main class application core 0.3.0
 *
 * author: Ivan Shibkikh ivan.shib@gmail.com
 */

 abstract class SysApplication
 {
    static private $error404Controller=null, $defaultControllerName=null, $defaultActionName=null;
     
    public function __construct($rootDir)
    { 
        define('PATH', $rootDir);
        require_once PATH.'core/SysAutoload.php';
        SysAutoload::init();
        SysErrorHandler::init();
        define('NEWLINE', '
');
    } 
    
    static public function registryError404($controllerName)
    {
        self::$error404Controller = $controllerName;
    }
    
    static public function registryDefaultRoute($controllerName, $actionName)
    {
        self::$defaultControllerName = $controllerName;
        self::$defaultActionName = $actionName;
    }
    
    static public function checkPath($Path)
    {
        if (!file_exists($Path))
        {
            throw new SysException('File or dir not found: "'.$Path.'"');
        }
    }

        static function system404()
    {
        if (self::$error404Controller == null)
           throw new SysException('Not registered controller for 404 error');
        if (ComRoute::getController() == self::$error404Controller)
           throw new SysException('Not found system controller "'.self::$error404Controller.'"');
        self::getInstance(self::$error404Controller);
        exit;
    }
 
    static public function init($debug, $timezone, $gzip, $lang)
    {
        If ($debug == 1)
        {
            define('DEBUG_MODE', true);
            ini_set("display_errors","1");
            ini_set('log_errors', '0');
            ini_set("error_reporting", E_ALL ^ E_NOTICE);
        }
        else
        {
            define('DEBUG_MODE', false);
            ini_set("display_errors","0");
            ini_set('error_log', PATH.'data/logs/error.log');
            ini_set("log_errors", 1);
            ini_set("error_reporting", E_ERROR);
        }
        
        
        date_default_timezone_set($timezone);
        ini_set("zlib.output_compression", $gzip);
        define('APP_LANG',  $lang);
    }
 
    static public function getInstance($iContrtoller, $iAction=null, $iModule=null)
    {
        header('X-Powered-By: DreamQ/1.0');
        if ($iContrtoller == null)
        {
            if (self::$defaultControllerName == null)
                throw new SysException('Not registered default controller');
            $iContrtoller = self::$defaultControllerName;
        }
        if ($iAction == null)
        {
            if (self::$defaultActionName == null)
                throw new SysException('Not registered default action');
            $iAction = self::$defaultActionName;
        }
        
        $action = $iAction.'Action';
        
        if ($iModule != null)
        {
            $src = PATH.'application/modules/'.$iModule.'/controllers/'.$iContrtoller.'Controller.php';
            if(!is_file($src))
            {
                self::system404();
            }
            define('WORK_PATH', PATH.'application/modules/'.$iModule.'/');
            require_once($src);
        }
        else
        {
            $src = PATH.'application/controllers/'.$iContrtoller.'Controller.php';
            if(!is_file($src))
            {
                self::system404();
            }
            define('WORK_PATH', PATH.'application/');
            require_once($src);
        }    
            
        $classname = $iContrtoller.'Controller';
        if (class_exists($classname))
        {
            $instance = new $classname();
        }
        else
        {
            self::system404();
        }
        if (method_exists($instance, $action))
        {
            if (method_exists($instance, '_init')) $instance->_init();
            $instance->$action();
            if (method_exists($instance, '_end')) $instance->_end();
        }
        else
        {
            if (method_exists($instance, '_autoload'))
            {
                if (method_exists($instance, '_init')) $instance->_init();
                $instance->_autoload($iAction);
                if (method_exists($instance, '_end')) $instance->_end();
            }
            else
            {
                self::system404();
            }
        }
    }
}

?>
