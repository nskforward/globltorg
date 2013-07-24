<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UISelectClass
 *
 * @author ishibkikh
 */
class UIList extends UIBaseElement
{
    protected $items, $selected;
    
    public function __construct($name, $values)
    {
        parent::__construct($name, $values['required']);
        $this->items = $values['items'];
        $this->selected = $values['selected'];
    }
    
    public function getHtml()
    {
        
        $html = '<select name="'.$this->name.'"><option value=""></option>';
        if (count($this->items) > 0)
        foreach ($this->items as $key => $value)
        {
            $selected = ($this->selected == $key)? ' selected': null;
            $html .= '<option'.$selected.' value="'.$key.'">'.$value.'</option>';
        }
        $html .= '</select>';
        return $html;
    }
}

?>
