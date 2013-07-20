<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComValidator
 *
 * @author ishibkikh
 */
class ComValidator
{
    static private $errors = array();

    static function getMask($name)
    {
        switch ($name)
        {
            case 'email' : return "/^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2,4}|museum|travel)$/"; break;
            case 'anum' : return "/^([a-z][-_0-9a-z]+)$/"; break;
            case 'alphastrings' : return "/^([,.-_ 0-9a-zA-Zа-яА-ЯёЁ]+)$/"; break;
            case 'num' : return "/^([0-9]+)$/i"; break;
            case 'decimal' : return "/^([0-9]+.[0-9]+)|([0-9]+)$/i"; break;
            case 'version' : return "/^([A-Za-z.0-9]+)$/i"; break;
            case 'phone' : return "/^([-+() 0-9]+)$/i"; break;
            case 'custom' : return "/^([-:!?.,_+() A-Za-z0-9а-яА-ЯёЁ]+)$/i"; break;
        }
    }
    
    static function getErrorText($name)
    {
        switch ($name)
        {
            case 'email' : return 'Неправильный формат адреса'; break;
            case 'anum' : return 'Только латинские буквы и цифры, первый символ не цифра'; break;
            case 'alphastrings' : return 'Только буквы, цифры и знаки препинания'; break;
            case 'num' : return 'Только цифры'; break;
            case 'version' : return 'Can be format: 0.0.0.0'; break;
            case 'custom' : return 'Содержатся запрещённые символы'; break;
            case 'phone' : return 'Только номер телефона'; break;
            case 'decimal' : return 'Только числа'; break;
        }
    }
    
    static function check($value, $maskname)
    {
        if (preg_match(self::getMask($maskname).'iu', $value, $matches) >0) return true;
        else return false;
    }
    
    static function format($value, $fname)
    {
        switch ($fname)
        {
            case 'trim' : return trim($value); break;
            case 'upperfirstletters' : return ucwords(strtolower($value)); break;
            case 'lowercase' : return strtolower($value); break;
            case 'uppercase' : return strtoupper($value); break;
            case 'hash256' : return WebApp::hash256($value); break;
            case 'hash512' : return WebApp::hash512($value); break;
        }
    }
    
    static public function getErrors()
    {
        return self::$errors;
    }
    
    static public function isValidate($inputs, $form)
    {
        self::$errors = array();
        $form = new ComForm($form);
        $elements = $form->getElements();
       
        foreach ($elements as $key => $setting)
        {
            if (($inputs[$key]==NULL)and($setting['required']==true))
            {
                self::$errors[$key] = 'Field is required';
            }
            else
            {
                if ($setting['formatting'])
                {
                    foreach ($setting['formatting'] as $format)
                    {
                        $inputs[$key] = self::format($inputs[$key], $format);
                    }
                }
                if ($setting['validator'])
                {
                    if (strlen($inputs[$key])>0)
                    {
                        if(!self::check($inputs[$key], $setting['validator'])) self::$errors[$key] = self::getErrorText($setting['validator']);
                    }
                }
                
                if ($setting['conformity'])
                {
                    if ($inputs[$key] != $inputs[$setting['conformity']]) self::$errors[$key] = 'Значения не совпадают';
                }
                if ($setting['unique'])
                {
                    if ((!$setting['unique']['table'])or(!$setting['unique']['field'])) throw new SysException('Invalid format of "unique" attribute ('.$key.')');
                    $row = ComDBCommand::getRow($setting['unique']['table'], array($setting['unique']['field'] => $inputs[$key]));
                    if ($row !== false) self::$errors[$key] = 'Это значение уже используется, введите другое';
                }
                if ($setting['type'] == 'captcha')
                {
                    ComWebUser::runAsGuestIfNotRunning();
                    if (ComSession::get('captcha_key') == NULL) self::$errors[$key] = 'Неверный код';
                    elseif (ComSession::get('captcha_key') != ComSecurity::hash256($inputs[$key])) self::$errors[$key] = 'Неверный код';
                    ComSession::delete('captcha_key');
                }
                if ($setting['type'] != 'captcha') $outputs[$key] = $inputs[$key];
            }    
        }
        if (count(self::$errors) == 0)
            return $inputs;
        else
            return false;
    }
}

?>
