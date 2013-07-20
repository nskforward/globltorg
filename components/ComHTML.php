<?php

class ComHTML
{
    static protected
            $html = '<!--BODY-->',
            $pre_path = null,
            $global_title,
            $template_variables = array();
    
    static public function getContent()
    {
        return self::$html;
    }
    
    public function __set($name, $value)
    {
        self::$template_variables[strtoupper($name)] = $value;
    }
    
    static public function setPath($path_name)
    {
        self::$pre_path = $path_name.'/';
    }
    
    static public function load($tpl_name, $isGlobal=false)
    {
        self::$html = ComTemplate::set_var(self::$html, 'BODY', ComTemplate::load(self::$pre_path.$tpl_name, $isGlobal));
    }
    
    
    static public function clear()
    {
        self::$html = '<!--BODY-->';
    }
    
    
    static public function title($title)
    {
        self::$global_title = $title;
    }
    
    static public function setVar($varname, $content, $iterator=false)
    {
        if ($iterator) $content .= NEWLINE.'<!--'.$varname.'-->';
        self::$html = ComTemplate::set_var(self::$html, $varname, $content);
    }

    static public function dispatch($content=NULL)
    {
        ComResponse::setContentType('html');
        if ($content != NULL)
        {
            echo $content;
        }
        else
        {
            self::$html = ComTemplate::set_var(self::$html, 'H_TITLE', self::$global_title);
            foreach (self::$template_variables as $key => $value)
            {
                self::setVar($key, $value);
            }
            self::renderForms();
            self::renderWidgets();
            ComResponse::HTML(self::$html);
        }
    }
   
    static public function packToJSON()
    {
        return array('message', array(self::$global_title => self::$html));
    }

    static public function setJS($name)
   { 
     if (substr($name, 0, 4) == 'http')
     {
        self::setVar('H_SCRIPT', '<script language="javascript" type="text/javascript" src="'.$name.'"></script>', true);
     }
     else
     {
        self::setVar('H_SCRIPT', '<script language="javascript" type="text/javascript" src="/js/'.$name.'.js"></script>', true);
     }
   }
   
   static public function setJSCode($text)
   { 
       self::setVar('H_SCRIPT', '<script type="text/javascript">'.$text.'</script>', true); 
   }
   
   static public function setCSS($name)
   { 
       self::setVar('H_CSS', '<link rel="stylesheet" type="text/css" href="css/'.$name.'.css">', true);  
   }
   
   static public function h1($text)
   { 
     self::append('<h1>'.$text.'</h1>');
   }
   
   static public function h2($text)
   { 
     self::append('<h2>'.$text.'</h2>');
   }
   
   static public function h3($text)
   { 
     self::append('<h3>'.$text.'</h3>');
   }
   
   static public function p($text)
   { 
     self::append('<p>'.$text.'</p>');
   }
   
   static public function hr()
   { 
     self::append('<hr>');
   }
   
   static public function br()
   { 
     self::append('<br>');
   }
   
   static public function div($text, $class=null, $id=null)
   { 
       if ($id !== null) $id = ' id="'.$id.'"';
       if ($class !== null) $class = ' class="'.$class.'"';
       self::append('<div'.$class.$id.'>'.$text.'</div>');
   }
   
   static public function append($text, $iterator=true)
   { 
       self::setVar('BODY', $text, $iterator);
   }
   
   static public function setForm($formname)
   { 
       $form = new ComForm($formname);
       $form->compile();
       self::setJSCode($form->getJavaScript());
       self::append($form->getHtml()); 
   }
   
   static public function meta($name, $value)
   {
       self::setVar('H_META', '<meta name="'.$name.'" content="'.$value.'">', true);
   }
   
   static public function renderForms()
   {
        $p1='/<!--\[(\w+)\]-->/';
        $n =preg_match_all($p1, self::$html, $matches);
        If ($n>0)
        { 
            for ($i=0; $i<=$n-1; $i++)
            {
                $p2='<!--['.$matches[1][$i].']-->';
                $form = new ComForm(strtolower($matches[1][$i]));
                $form->compile();
                self::$html = str_replace($p2, $form->getHtml(), self::$html);
                self::setJSCode($form->getJavaScript());
            }
        }
   }
   
   static public function renderWidgets()
   {
    $p1='/<!--\{([ -_0-9A-Z]+)\}-->/';
    $n =preg_match_all($p1, self::$html, $matches);
    If ($n>0)
    { 
      for ($i=0; $i<$n; $i++)
 	{
         $p2='<!--{'.$matches[1][$i].'}-->';
         $wname = strtolower($matches[1][$i]).'Widget';
         $src = PATH.'application/widget/'.$wname.'.php';
         WebApp::checkPath($src);
         require_once $src;
         self::$html = str_replace($p2, $wname::getContent(), self::$html);
        }
    }    
   }
   
}

?>
