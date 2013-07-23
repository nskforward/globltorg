<?php

/**
 * DreamQ core modul 0.3.0
 * Global class templateClass
 */

class ComTemplate {
   
   static public function load($template_name)
   {
       $template_file = WORK_PATH.'views/'.$template_name.'.tpl';
       if (!file_exists($template_file)) 
       {
           $template_file = PATH.'application/views/'.$template_name.'.tpl';
       }
       WebApp::checkPath($template_file);
       return file_get_contents($template_file);
   }
   

   static public function set_var($source, $var_name, $var_value)
   {
       if (stripos($source, '<!--'.$var_name.'-->') === false)
               throw new SysException('Not found template var "'.$var_name.'"'.NEWLINE.$source);
       return str_replace('<!--'.$var_name.'-->', $var_value, $source);
   }
   
   
  /*
   public function setWidget($data)
   {
    $p1='/<!--\{([ -_0-9A-Z]+)\}-->/';
    $n =preg_match_all($p1, $data, $matches);
    If ($n>0)
    { 
      for ($i=0; $i<$n; $i++)
 	{
         $p2='<!--{'.$matches[1][$i].'}-->';
         $wname = strtolower($matches[1][$i]).'Widget';
         $src = PATH.'application/widget/'.$wname.'.php';
         if (!file_exists($src))
         {
             throw new Exception('Not found: '.$src);
         }
         require_once $src;
         $widget = new $wname();
         $data = str_replace($p2, $widget->getHtml(), $data);
        }
    }    
    return $data;
   } 
 */
/*  
   public function localiz($data)
   {
        $p1='/%\{([^}]+)\}/';
 	$n =preg_match_all($p1, $data, $matches);
        
 	for ($i=0; $i<$n; $i++)
 	{
            $p2='%{'.$matches[1][$i].'}';
            $data = str_replace($p2, WebApp::tsl($matches[1][$i]), $data);
 	}
 	return $data;
   } 
 * 
 */
}

?>
