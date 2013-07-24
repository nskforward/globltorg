<?php

/**
 * Description of UICheckboxClass
 *
 * @author ivan
 */
class UICheckbox extends UIBaseElement
{
    protected $title;
    protected $value;
    
    public function __construct($name, $values)
    {
        parent::__construct($name, false);
        $this->title = $values['title'];
        $this->value = $values['value'];
    }
    
    public function getHtml()
    {
        $checked = ($this->value == true)?' checked':null;
        return '<input type="checkbox" name="'.$this->name.'" value="'.$this->value.'"'.$checked.'>'.$this->title;
    }
}

?>
