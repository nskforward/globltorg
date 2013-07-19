<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComSms
 *
 * @author ishibkikh
 */
class ComSms
{
    static $email = 'f87d849a-698e-a814-e94e-57bc95d6b2b9@sms.ru';
    static $from = 'GLOBLTORG';
    
    static function send($number, $text)
    {
        $m = new ComMail();
        $m->From('info@globltorg.com');
        $m->To(self::$email);
        $m->Subject($number.' from:'.self::$from);
        $m->Body($text);
        $m->Priority(2);
        $m->Send();
    }
}

?>
