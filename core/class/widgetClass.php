<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * World widget of widgetClass
 *
 * @author ivan
 */
class widgetClass {
    private $css_name;
    private $content;
    
  public function get()
  {
      return $this->content;
  }
  
  public function load($name)
  {
    $file_name = '../application/widget/'.$name.'Widget.php';
    if (!is_file($file_name)) throw new CustomException('Not found: '.$file_name);
    require_once($file_name);
    $this->content = call_user_func('get_'.$name.'Widget');
    $this->css_name = call_user_func('get_'.$name.'CSS');
  }
  
  public function getNameCSS()
  {
      return $this->css_name;
  }
    
}

?>
