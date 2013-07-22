<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class radioUIClass extends UIBaseElementClass
{
    public function __construct($name, $values)
    {
        parent::__construct($name, $values['required']);
        $this->items = $values['items'];
        $this->selected = $values['selected'];
        $this->position = $values['position'];
        if ($this->selected === null) throw new CustomException('Undefined selected item in radio group ('.$name.')');
    }
    
    public function getHtml()
    {
        $separator = ($this->position == 'h')? '&nbsp;&nbsp;&nbsp;&nbsp;' : '<br>';
        $html = NULL;
        foreach ($this->items as $key => $value)
        {
            $checked = ($key == $this->selected)? ' checked':NULL;
            $html .= '<input type="radio" name="'.$this->name.'" value="'.$key.'"'.$checked.'>'.$value.$separator;
        }
        return $html;
    }
}
?>
