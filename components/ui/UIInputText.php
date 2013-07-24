<?php

/**
 * Description of UIInputTextClass
 *
 * @author ishibkikh
 */

class UIInputText extends UIInput
{
    protected $min, $max;
    public function __construct($name, $values)
    {
        parent::__construct($name, $values['value'], $values['required']);
        $this->min = ($values['minLength'] == NULL)? 0 : $values['minLength'];
        $this->max = ($values['maxLength'] == NULL)? 256 : $values['maxLength'];
        $this->javaScript('length','if(value.length>'.$this->max.'){put_error("'.$this->name.'","Длина не может быть более '.$this->max.' символов");}if((value.length>0)&&(value.length<'.$this->min.')){put_error("'.$this->name.'","Длина не может быть менее '.$this->min.' символов");}');
    }
    
    public function setLenght($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }
    
    public function getHtml()
    {
        return '<input name="'.$this->name.'" type="text" value="'.$this->value.'" maxlength="'.$this->max.'">';
    }
}

?>
