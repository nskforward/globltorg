<?php

/**
 * Description of UIInputPasswordClass
 *
 * @author ishibkikh
 */
class UIPrint extends UIBaseElement
{
    private $value;
    
    public function __construct($name, $values)
    {
        parent::__construct($name, false);
        $this->value = $values['value'];
    }
   
    public function getHtml()
    {
        return '<p>'.$this->value.'</p>';
    }
}

?>
