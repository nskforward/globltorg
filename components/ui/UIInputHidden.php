<?php
/**
 * Description of UISubmitClass
 *
 * @author ishibkikh
 */
class UIInputHidden extends UIBaseElement
{
    protected $link, $value, $formname, $action, $sn_button;
    
    public function __construct($name, $values)
    {
        parent::__construct($name, false);
        $this->value = $values['value'];
    }

    public function getHtml()
    {
        return '<input name="'.$this->name.'" type="hidden" value="'.$this->value.'">';
    }
 }

?>
