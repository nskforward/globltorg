<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CConfig
 *
 * @author ishibkikh
 */
class ComConfigINI implements IConfig
{
   static private $config, $now_mode;
      
   static public function init($filename)
   {
     $file = PATH.'config/'.$filename;
     WebApp::checkPath($file);
     self::$config = parse_ini_file($file, true);
     If (self::$config['now']['production']=='1')
         self::$now_mode = 'production';
     else
         self::$now_mode = 'development';
   }
   
  static public function get($property)
  {
     if (isset(self::$config[self::$now_mode][$property]))
         {
            return self::$config[self::$now_mode][$property];
         }
     else
         {
            throw new SysException('Property "'.$property.'" not found in config.ini');
         }
  }
  
  
}

?>
