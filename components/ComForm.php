<?php

/**
 * @author Ivan Shibkikh ivan.sh@mail.com
 */

class ComForm
{
    private $name, $description, $header, $action, $submit_title, $method, $class, $autocomplete, $html=NULL, $javascript;
    private $elements = array();
    
    public function __construct($param=null)
    {
        if (is_array($param)) $array = $param;
        elseIf ($param != null)
        {
            $file = WORK_PATH.'forms/'.$param.'.php';
            if (!file_exists($file)) $file = PATH.'application/forms/'.$param.'.php';
            WebApp::checkPath($file);
            require_once $file;
            $func = 'getForm'.$param;
            $array = $func();
        }
        else
        {
            $array = array();
        }
        foreach ($array as $key => $value)
        {
            if ($key == 'autocomplete') $this->autocomplete = $value == true ? 'on' : 'off';
            else $this->{$key} = $value;
        }
    }
    
    public function editAction($action)
    {
        $this->action = $action;
    }
    
    public function editSubmitTitle($title)
    {
        $this->submit_title = $title;
    }

        public function getElements()
    {
        return $this->elements;
    }

    public function addListItem($element, $name, $value)
    {
        $this->elements[$element]['items'][$name] = $value;
    }
    
    public function addElement($name, $el=array())
    {
        foreach ($el as $key => $value)
        {
            $this->elements[$name][$key] = $value;
        }
    }
    
    public function removeAttr($name)
    {
        $this->{$name} = null;
    }
    
    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }
    
    private function prepare()
    {
        if ($this->method == null) $this->method = 'post';
        if ($this->autocomplete == null) $this->autocomplete = 'on';
        if ($this->class != null) $this->class = 'class="'.$this->class.'" ';
   }
    
    public function compile()
    {
        $this->prepare();
        $this->javascript = NULL;
        if ($this->enctype) $enctype = ' enctype="'.$this->enctype.'"';
        else $enctype = NULL;
        $form_header = ($this->header)?'<h2>'.$this->header.'</h2>':null;
        $form_desc = ($this->description)?'<p>'.$this->description.'</p>':null;
        $this->html = $form_header.$form_desc.'<form name="'.$this->name.'"'.$enctype.' action="/'.$this->action.'" method="'.$this->method.'" '.$this->class.'autocomplete="'.$this->autocomplete.'"><table>';
        foreach ($this->elements as $key => $element)
        {
            $output = null;
            $src = PATH.'components/ui/UIBaseElement.php';
            require_once $src;
            $class = 'UI'.ucfirst($element['type']);
            $src = PATH.'components/ui/'.$class.'.php';
            WebApp::checkPath($src);
            require_once $src;
            $output = new $class($key, $element);
             
            if ($element['required']==true) $star = '<em>*</em>'; else $star = NULL;
            if ($element['type'] != 'hidden')
            {
                $this->html .= '<tr><td class="label">'.$element['label'].$star.'</td><td>'.$output->getHtml().'</td></tr>';
            }
            else
            {
                $this->html .= $output->getHtml();
            }
            if ($element['validator'])
            {
                $pattern = ComValidator::getMask($element['validator']);
                $errortext = ComValidator::getErrorText($element['validator']);
                $output->javaScript('validator','var pattern='.$pattern.';if((value.length>0)&&(!pattern.test(value))){put_error("'.$key.'","'.$errortext.'");}');
            }
            if ($element['conformity'])
            {
                $output->javaScript('custom','if(value != document.forms[\''.$this->name.'\'].'.$element['conformity'].'.value){put_error("'.$key.'","Значения не совпадают");}');
            }
            $javascript = $output->getJavaScript();
            if (count($javascript)> 0)
            {
                if ($javascript['required']!=NULL)
                {
                    $this->javascript .= 'function checkform_'.$this->name.'_'.$key.'_required(value){'.$javascript['required'].'}';
                }
                if ($javascript['length']!=NULL)
                {
                    $this->javascript .= 'function checkform_'.$this->name.'_'.$key.'_length(value){'.$javascript['length'].'}';
                }
                if ($javascript['validator']!=NULL)
                {
                    $this->javascript .= 'function checkform_'.$this->name.'_'.$key.'_validator(value){'.$javascript['validator'].'}';
                }
                if ($javascript['custom']!=NULL)
                {
                    $this->javascript .= 'function checkform_'.$this->name.'_'.$key.'_custom(value){'.$javascript['custom'].'}';
                }
             }
        }
        $this->html .= '<tr><td></td><td><button id="submit" onclick="checkForm(\''.$this->name.'\', \''.$this->action.'\'); return false;">'.$this->submit_title.'</button></td></tr>';
        $this->html .= '</table></form>';
    }

    public function getHtml()
    {
        if ($this->html==NULL) return 'Please compile form before';
        else return $this->html;
    }
    
    public function getJavaScript()
    {
        if ($this->javascript==NULL) return 'Please compile form before';
        else return $this->javascript;
    }
}
?>