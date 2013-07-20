<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function mainWidgetBodyCode($name, $group = 'default')
{
    $file_name = '../application/widget/'.$name.'Widget.php';
    if (!is_file($file_name)) throw new CustomException('Not found: '.$file_name);
    require_once $file_name;
    $css = call_user_func('get_'.$name.'CSS');
    $data = '';
    If ($css != NULL)
    {
        $file_name = '../public/css/'.$css.'Widget.css';
        if (is_file($file_name))
         {
             $data .= '<link rel="stylesheet" type="text/css" href="css/'.$css.'Widget.css">';
         }
    }     
   $data .= call_user_func('get_'.$name.'Widget');
   echo $data;
   $cache = new Cache_Lite;
   $cache->save($data, $name, $group);
}

function checkCache($name, $group)
{
    $cache = new Cache_Lite;
    If ($data = $cache->get($name, $group))
    {
        echo $data;
        exit;
    }
    else
    mainWidgetBodyCode($name, $group);
}

switch ($this->params[1])
{
case "world":
    $this->setContentType('html');
    checkCache($this->params[1], 'WGM');
    break;
case "russia":
    $this->setContentType('html');
    checkCache($this->params[1], 'WGM');
    break;
case "barnaul":
    $this->setContentType('html');
    checkCache($this->params[1], 'WGM');
    break;
default :
    $this->setContentType('text');
    $this->setCode('404');
    $this->setResponse('Widget not found', 0);
}

?>
