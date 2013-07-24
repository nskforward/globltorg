<?php

/**
 * Description of UIInputTextClass
 *
 * @author ishibkikh
 */

class UITextarea extends UIInput
{
    protected $min, $max, $id;
    public function __construct($name, $values)
    {
        parent::__construct($name, $values['value'], $values['required']);
        $this->min = ($values['minLength'] == NULL)? 0 : $values['minLength'];
        $this->max = ($values['maxLength'] == NULL)? 256 : $values['maxLength'];
        $this->id = ($values['id'] == NULL)? null : ' id="'.$values['id'].'"';
        $this->javaScript('length','if(value.length>'.$this->max.'){put_error("'.$this->name.'","Длина не может быть более '.$this->max.' символов");}if((value.length>0)&&(value.length<'.$this->min.')){put_error("'.$this->name.'","Длина не может быть менее '.$this->min.' символов");}');
    }
    
    public function setLenght($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }
    
    public function getHtml()
    {
        return '<textarea'.$this->id.' maxlength="'.$this->max.'" wrap="soft" name="'.$this->name.'">'.$this->value.'</textarea>';
    }
}

?>
