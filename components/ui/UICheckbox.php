<?php

/**
 * Description of UICheckboxClass
 *
 * @author ivan
 */
class UICheckbox extends UIBaseElement
{
    protected $title;
    protected $selected;
    
    public function __construct($name, $values)
    {
        parent::__construct($name, false);
        $this->title = $values['title'];
        $this->selected = $values['selected'];
    }
    
    public function getHtml()
    {
        $checked = ($this->selected == true)?' checked':null;
        return '<input type="checkbox" name="'.$this->name.'" value="1"'.$checked.'>'.$this->title;
    }
}

?>
