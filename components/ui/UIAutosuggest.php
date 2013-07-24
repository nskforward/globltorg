<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UIAutosuggestClass
 *
 * @author ishibkikh
 */
class UIAutosuggest extends UIBaseElement
{
    protected $value;
    
    public function __construct($name, $values)
    {
        parent::__construct($name, $values['required']);
        $this->value = $values['value'];
    }
    

    public function getHtml()
    {
        return '<input name="'.$this->name.'" type="text" value="'.$this->value.'" class="autocomplete">';
    }
}

?>
