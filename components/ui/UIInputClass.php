<?php

/**
 * Description of UIFormBaseInputClass
 *
 * @author ishibkikh
 */
abstract class UIInputClass extends UIBaseElementClass
{
    protected $value;
    
    public function __construct($name, $value, $req)
    {
        parent::__construct($name, $req);
        $this->value = $value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}

?>
