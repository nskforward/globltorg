<?php

/*
 * Main class application core 1.0.0
 *
 * author: Ivan Shibkikh ivan.shib@gmail.com
 */

class appClass
 {
   protected $page,         
             $content = "<!--BODY-->",
             $general_content,
             $title,
             $charset,      
             $type,         
             $params,
             $count_params,
             $method,
             $post,
             $template,
             $sess,
             $cacheKey,
             $cache,
             $config,
             $lang;
  
  public function __construct()
  {
    require_once('exceptionClass.php');
 
// language
    If ($_COOKIE['lang'])
    {
        If ($_COOKIE['lang'] == 'rus')
        {
            $this->lang = 'rus';
        }
        
        If ($_COOKIE['lang'] == 'eng')
        {
            $this->lang = 'eng';
        }
    }
    else
    {
        If (substr_count($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'ru') > 1)
        {
            $this->lang = 'rus';
        }
        else
        {
            $this->lang = 'eng';
        }
    }
    
    define('LANG',    $this->lang);
    
 // Routing
    
    $url = $_SERVER['REQUEST_URI'];
    $this->method = $_SERVER['REQUEST_METHOD'];
    If ($this->method == "POST") $this->post = $_POST;
    $this->count_params = preg_match_all("/\/([-_0-9a-z.]+)/", $url, $params);
    If ($this->count_params == 0)
    {
        $this->page = 'home';
    }
    else
    {
        //echo $params[1][0].'  '.$params[1][1];
        If (!$this->page_is_reg($params[1][0]))
          {
            $this->page = "error";
          } 
        else
          {
            $this->page = $params[1][0];
            If ($this->count_params > 0)
            {    
                for ($i=1; $i<$this->count_params; $i++)
                {
                    $this->params[$i] = $params[1][$i];
                }
            }
          }  
    }    
    
 // Session
    require_once('sessClass.php');
    session_save_path('../data/sessions');
    $this->sess = new sessClass();
    define("isSESS", $this->sess->isStart());
      
 // Config
    require_once('configClass.php');
    $this->config = new configClass('../config.ini');
    If ($this->config->display_errors == 1) ini_set("display_errors","1");
    else ini_set("display_errors","0");
    define("DISPLAY_ERRORS", $this->config->display_errors);
    If ($this->config->log_errors == 1) ini_set("log_errors","1");
    else ini_set("log_errors","0");
    If ($this->config->error_reporting == 0) ini_set("error_reporting", E_ALL ^ E_NOTICE);
    else ini_set("error_reporting", E_ERROR);
    ini_set('error_log', '../data/logs/errors.log');
    define('DB_SERVER',     $this->config->db_host);
    define('DB_DATABASE',   $this->config->db_name);
    define('DB_USER',       $this->config->db_user);
    define('DB_PASSWORD',   $this->config->db_password);
    define('CHARSET',       $this->config->charset);
    
    //ini_set('upload_tmp_dir','../data/uploads');
    
 // Cache
    //require_once('cache/Lite.php');
    
    $this->GenerationPage();
  }
  
 
 function SetNotFound($sel = null)
 {
    $this->setContentType('html');
    if ($sel == null)
    {
        $this->loadMainTemplate('error');
    }
    else
    {
        $this->content = $this->template->set_var($this->template->load("cms"), 'MAIN_PANEL', $this->template->load('error'));
    }
        
    $this->setTitle('Страница не найдена');
    $this->setCode("404");
    $this->setVar('URL', $_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
    $this->setResponse();
    exit;
 }
 
  
 private function setLSBar($top, $down)
 {
   if ($down <> null)
   $this->setVar('LEFT_SIDEBAR', '<div id="sidebar-1" class="sidebarN" ><div class="frame-img-1"><div><img style="visibility: hidden;" onload="resizing_pictures(this,349,222,\'cnow\');" src="/img/'.$top.'" alt=""></div></div><div class="frame-img-2"><div><img style="visibility: hidden;" src="/img/'.$down.'" onload="resizing_pictures(this,343,221,\'cnow\');" alt=""></div></div></div>');
   elseIf($top <> null)
   $this->setVar('LEFT_SIDEBAR', '<div id="sidebar-1" class="sidebarN" ><div class="frame-img-1"><div><img style="visibility: hidden;" onload="resizing_pictures(this,349,222,\'cnow\');" src="/img/'.$top.'" alt=""></div></div></div>');
 }
 
 private function setRSBar($cen)
 {
   if ($cen <> null)
     $this->setVar('RIGHT_SIDEBAR', '<div id="sidebar-2" class="sidebarN"><div class="frame-img-3"><div><img style="visibility: hidden;" onload="resizing_pictures(this,348,310,\'cnow\');" src="/img/'.$cen.'" alt="" /></div></div></div>');
 }
 
 private function GenerationPage()
 {
   require_once('templateClass.php');
   require_once('dbClass.php');
   require_once('validatorClass.php');
   require_once('../core/scripts/api.php');
   $this->setHeader("X-Powered-By", "DreamQ/1.0");
   $this->template = new templateClass;
   $src = '../application/controllers/'.$this->page.'Controller.php';
   if(!is_file($src)) throw new CustomException('Not found: '.$src);
   require_once($src);
 }
 
 private function setCode($name)
   { 
     switch ($name)
     {
       case "404": header("HTTP/1.1 404 Not Found"); break;
       default: header("HTTP/1.1 200 OK");
     }
   }
 
 private function protectAccess()
 { 
     If (isSESS == false)
    {
        $this->redirect('/login');
        exit;
    }
 }
 
 private function setResponse($text = '')
   { 
     /*
     If ($whithGeneral == 1)
     {
         if ($text)
            $this->content = $this->template->set_var($this->template->load("general"), 'BODY', $text);
         else
            $this->content = $this->template->set_var($this->template->load("general"), 'BODY', $this->content);
         $this->content = $this->template->set_var($this->content, 'TITLE', $this->title);
     }
     else
     {
        If ($text)
        $this->content = $text;
     }
  
     echo $this->content;
      * 
      */
     if ($text)
     $this->content = $this->template->set_var($this->content, 'BODY', $text);
     
     $this->content = $this->template->set_var($this->content, 'TITLE', $this->title);
     $this->content = $this->template->set_var($this->content, 'CONTACT_EMAIL', $this->config->contact_email);
     $this->content = $this->template->set_var($this->content, 'CONTACT_PHONE', $this->config->cantact_phone);
     
     $db = new dbClass('course');
     $courses = $db->getAllValues();
     $count = $db->count();
     $text = '';
     If ($count == 1)
     {
         $text = $courses->sign.' '.$courses->value;
     }
     elseIf ($count > 1)
     {
         $text = $courses[0]->sign.' '.$courses[0]->value;
         For ($i=1;$i<$count;$i++)
         {
            $text .= ' | '.$courses[$i]->sign.' '.$courses[$i]->value;
         }
     }
     $this->content = $this->template->set_var($this->content, 'COURSES', $text);
     
     echo $this->content;
   }

   
 private function loadMainTemplate($sel=null)
 { 
// Cache control
     /*
   If ($this->config->app_cache == 1)
    {
        $this->cache = new Cache_Lite;
        if ($data = $this->cache->get($this->cacheKey))
        {
            $this->content = $this->template->set_var($this->template->load("general"), 'BODY', $data);
            $this->content = $this->template->set_var($this->content, 'TITLE', $this->title);
            echo $this->content;
            exit;
        }
    }
   $this->content = $this->template->load($this->page);
      */
   If ($sel == null)
   {
       $this->content = $this->template->set_var($this->template->load("general"), 'BODY', $this->template->load($this->page));
   }
   elseIf ($sel == 1)
   {
       $this->content = $this->template->load("general");
   }
   else
   {
       $this->content = $this->template->set_var($this->template->load("general"), 'BODY', $this->template->load($sel));
   }
        
 }

 
 private function setTitle($value)
   { 
     $this->title = $value;
   }
 
   
 private function setVar($var, $value)
   { 
     $this->content = $this->template->set_var($this->content, $var, $value);
   }
 
 private function redirect($url)
   { 
     header("Location: ".$url);
   }
 
 private function setHeader($name, $value)
 {
     header($name.": ".$value);
 }
 
 private function setContentType($type, $charset=CHARSET)
   { 
    If ($this->config->gzip == 1) ob_start('ob_gzhandler');
    switch ($type)
     {
      case "html": header('Content-Type: text/html;charset='.$charset); break;
      case "text": header('Content-Type: text/plain;charset='.$charset); break;
      case "xhtml": header('Content-Type: application/xhtml+xml;charset='.$charset); break;
      case "xml": header('Content-Type: text/xml;charset='.$charset); break;
      case "json": header('Content-Type: application/json;charset='.$charset); break;
      case "jpeg": header('Content-Type: image/jpeg'); break;
      default: header('Content-Type: text/html;charset='.$charset); break;
     }
   }
   
  private function noCache()
   { 
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', FALSE);
    header('Pragma: no-cache');
   } 
   
  private function page_is_reg($name)
   {
    $src = '../application/xml/pages.xml';
    if(!is_file($src)) throw new CustomException('Not found: '.$src);
    $xml   = simplexml_load_file($src);
    If (count($xml->xpath("//page[text()='".$name."']")) > 0)
    return true;
    else
    return false;
   }
 }

?>
