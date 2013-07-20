<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class captchaUIClass extends UIBaseElementClass
{
    protected $max;
    
    public function __construct($name, $values)
    {
        parent::__construct($name, $values['required']);
        $this->max = ($values['maxLength'] == NULL)? 255 : $values['maxLength'];
    }
    
    public function getHtml()
    {
        return '<table><tr><td><img id="captcha" src="/captcha" name="cod"></td><td><em class="link" onclick="ReCaptcha();">Обновить</em></td></tr></table><br><input name="'.$this->name.'" type="text" maxlength="'.$this->max.'">';
    }

}

?>
