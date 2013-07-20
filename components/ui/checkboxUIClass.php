<?php

/**
 * Description of UICheckboxClass
 *
 * @author ivan
 */
class checkboxUIClass extends UIInputClass
{
    protected $title;
    
    public function __construct($name, $values)
    {
        parent::__construct($name, 'checkbox', $values, null, null, false);
        $this->title = $values['title'];
    }
    
    public function getHtml()
    {
        return '<input type="checkbox" name="'.$this->name.'" value="'.$this->value.'">'.$this->title;
    }
}

?>
