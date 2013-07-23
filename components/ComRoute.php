<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComURL
 *
 * @author ishibkikh
 */
class ComRoute implements IRoute
{
    static private $inputUrl, $controller=null, $action=null, $params=array(), $module = null;
 
    static public function init()
    {
        self::$inputUrl = strtolower($_SERVER['REQUEST_URI']);
        $count = preg_match_all("/\/([-_0-9a-z.]+)/", self::$inputUrl, $params);
        If ($count > 0)
        {    
            for ($i=0; $i<$count; $i++)
            {
                $result[$i] = strtolower($params[1][$i]);
            }
            $path = PATH.'application/controllers/'.$result[0].'Controller.php';
            if (file_exists($path))
            {
                self::$module = null;
                self::$controller = $result[0];
                self::$action = $result[1];
                $j = 0;
                for ($i=2; $i<$count; $i++)
                {
                    self::$params[$j] = $result[$i];
                    $j++;
                }
            }
            else
            {
                self::$module = $result[0];
                self::$controller = $result[1];
                self::$action = $result[2];
                $j = 0;
                for ($i=3; $i<$count; $i++)
                {
                    self::$params[$j] = $result[$i];
                    $j++;
                }
            }
        }
        else
        {
            self::$module = null;
            self::$controller = null;
            self::$action = null;
        }
    }

    static public function leftUrl()
    {
        self::$controller = self::$action;
        self::$action = array_shift(self::$params);
    }
    
    static public function getController()
    {
        return self::$controller;
    }
    
    static public function getAction()
    {
        return self::$action;
    }
    
    static public function getParams()
    {
        return self::$params;
    }
    
    static public function getModule()
    {
        return self::$module;
    }
    
    static public function actionsToControllers()
    {
        return self;
    }
}

?>
