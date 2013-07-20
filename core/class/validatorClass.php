<?php

/*
 * class validation 1.0.0
 */

/**
 * @author Ivan Shibkikh ivan.sh@mail.com
 */

class validatorClass
 {
   protected $src, $name;
   public $errorText, $isError;
   
    public function __construct($name)
   {
    $this->src = '../application/userdata/validator/'.$name.'Validator.xml';
    if(!is_file($this->src)) throw new CustomException('Not found: '.$this->src);
    $this->name = $name;
    $this->isError = false;
   }
   
   public function loadParams($params)
   {
    $xml = simplexml_load_file($this->src);
   foreach($xml->field as $field)
     {
       if ($field['type'] == "date")
        {  
         $value = intval($params[''.$field['name'].'_d']);
         if (($field['req']=="true")and($field['type'] != "submit"))
         {
          if (($value > 31)or($value < 1)){$this->isError = true; $this->errorText = 'Не заполнено поле < '.$field.' >';break;}
         }
         $value = intval($params[''.$field['name'].'_m']);
         if (($field['req']=="true")and($field['type'] != "submit"))
         {
          if (($value > 12)or($value < 1)){$this->isError = true; $this->errorText = 'Не заполнено поле < '.$field.' >';break;}
         }
         $value = intval($params[''.$field['name'].'_y']);
         if (($field['req']=="true")and($field['type'] != "submit"))
         {
          if (($value > 2300)or($value < 1900)){$this->isError = true; $this->errorText = 'Не заполнено поле < '.$field.' >';break;}
         }
        } 
       else $value = $params[''.$field['name'].''];
       
       if (($field['req']=="true")and($field['type'] != "submit"))
        {
          if ($value == ""){$this->isError = true; $this->errorText = 'Не заполнено поле < '.$field.' >';break;}
        }
       if (($field['min'])and($value))
        {
          $min = (int) $field['min'];
          if (mb_strlen($value, CHARSET) < $min){$this->isError = true; $this->errorText = 'Поле < '.$field.' > должно содержать минимум '.$min.' символов';break;}
        }
       if ($field['max'])
        {
          $max = (int) $field['max'];
          if (mb_strlen($value, CHARSET) > $max){$this->isError = true; $this->errorText = 'Поле < '.$field.' > превышает максимальных '.$max.' символа';break;}
        } 
       if ($field['type']=="alpha-number")
        {
         $pattern = '/^([a-z][[:alnum:]]+)$/';
         $n = preg_match($pattern, $value);
         if ($n == 0){$this->isError = true; $this->errorText = 'Поле < '.$field.' > должно содержать только буквы латинского алфавита или цифры, но не может начинаться с цифры';break;}
        }
       if ($field['type']=="strings-alpha")
        {
         $pattern = '/^([-, a-zа-яё]+)$/iu';
         $n = preg_match($pattern, $value);
         if ($n == 0){$this->isError = true; $this->errorText = 'Поле < '.$field.' > должно содержать только буквенные символы, тире или пробел';break;}
        }
       if ($field['type']=="alpha")
        {
         $pattern = '/^([a-zа-яё]+)$/iu';
         $n = preg_match($pattern, $value);
         if ($n == 0){$this->isError = true; $this->errorText = 'Поле < '.$field.' > должно содержать только буквенные символы';break;}
        }
       if ($field['type']=="repassword")
        {
         $parent = $params[''.$field['parent'].''];
         if ($value != $parent){$this->isError = true; $this->errorText = 'Неверное значение в поле < '.$field.' >';break;}
        }
       if ($field['type']=="email")
        {
         $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/';
         $n = preg_match($pattern, $value);
         if ($n == 0){$this->isError = true; $this->errorText = 'Неверный формат введённого '.$field;break;}
        } 
       if ($field['type']=="captcha")
        {
         $key = $_SESSION['keystring'];
         if ($key != md5($value)){$this->isError = true; $this->errorText = 'Введён неверный код в поле < '.$field.' >';break;}
        } 
     } 
   } 
 }
?>