<?php

/**
 * Description of UICheckboxClass
 *
 * @author ivan
 */
class UICheckbox extends UIInput
{
    protected $title;
    
    public function __construct($name, $values)
    {
        parent::__construct($name, 'checkbox', $values, null, null, false);
        $this->title = $values['title'];
    }
    
    public function getHtml()
    {
        $checked = ($this->value == true)?' checked':null;
        return '<input type="checkbox" name="'.$this->name.'" value="'.$this->value.'"'.$checked.'>'.$this->title;
    }
}

?>
