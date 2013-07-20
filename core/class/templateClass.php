<?php

/**
 * DreamQ core modul 1.0.0
 * Global class templateClass
 */

class templateClass {
   private $document;
   
   public function load($name, $dir='../application/templates/', $postfix='Template.tpl')
   {
    $template_file = $dir.$name.$postfix;
    if (!is_file($template_file)) throw new CustomException('Not found: '.$template_file);
    $fp = fopen($template_file,'r');
    $this->document = fread($fp,filesize($template_file));
    fclose($fp); 
    $this->document = $this->setForm($this->document);
    $this->document = $this->setWidget($this->document);
    $this->document = $this->localiz($this->document);
    return $this->document;
   }

   public function set_var($source, $var_name, $var_value)
   {
    return str_replace('<!--'.$var_name.'-->', $var_value, $source);
   }
   
   public function setForm($data)
   {
    $p1='/<!--\[(\w+)\]-->/';
    $n =preg_match_all($p1, $data, $matches);
    If ($n>0)
    { 
      require_once(PATH."formClass.php");
      for ($i=0; $i<=$n-1; $i++)
 	{
 	 $p2='/<!--\['.$matches[1][$i].'\]-->/';
         $form = new formClass(strtolower($matches[1][$i]));
 	 $data = preg_replace($p2, $form->getHTML(), $data);
 	}
    }
    return $data;
   } 
   
   public function setWidget($data)
   {
    $p1='/<!--\{([ -_0-9A-Z]+)\}-->/';
    $n =preg_match_all($p1, $data, $matches);
    If ($n>0)
    { 
      require_once(PATH."widgetClass.php");
      $widget = new widgetClass();
      for ($i=0; $i<=$n-1; $i++)
 	{
 	 $content = '';
         $p2='/<!--\{'.$matches[1][$i].'\}-->/';
         $res = explode(' ', $matches[1][$i]);
         $wname = strtolower($res[0]);
         $wgrop = $res[1];
         
         $widget->load($wname);
         $css_name = $widget->getNameCSS();
            If ($css_name != NULL)
            {  
                $file_name = '../public/css/'.$css_name.'Widget.css';
                if (file_exists($file_name))
                    {
                        $content = '<link rel="stylesheet" type="text/css" href="css/'.$css_name.'Widget.css">';
                    }
                else
                    throw new CustomException('Not found: '.$file_name);
            }
            $content .= $widget->get();
            $data = preg_replace($p2, $content, $data);
        }
    }    
    return $data;
   } 
   
  
   private function localiz($data)
   {
 	$p1='/<!--%(\w+)%-->/';
 	$n =preg_match_all($p1, $data, $matches);
 	for ($i=0; $i<=$n-1; $i++)
 	{
 	 $p2='/<!--%'.$matches[1][$i].'%-->/';
 	 $data = preg_replace($p2, translate($matches[1][$i]), $data);
 	}
 	return $data;
   } 
}

?>
