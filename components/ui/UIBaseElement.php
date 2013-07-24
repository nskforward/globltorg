<?php

/**
 * Description of UIFormElementClass
 *
 * @author ishibkikh
 */
abstract class UIBaseElement
{
    protected $name, $javascript=array();
    
    abstract public function getHtml();

    public function __construct($name, $req)
    {
        $this->name  = $name;
        if ($req == true)
        {
            $this->javascript('required','if(value.length==0){put_error("'.$this->name.'","Обязательно");}');
        }
    }
    
    final public function javaScript($flag, $code)
    {
        $this->javascript[$flag] = $code;
    }
    
    final public function getJavaScript()
    {
        return $this->javascript;
    }
}

?>
