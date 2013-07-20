<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CSecurity
 *
 * @author ishibkikh
 */
class ComSecurity
{
    static private $crypt_obj=null;
    
    static public function encrypt($text, $salt)
    {
        if (self::$crypt_obj === null)
        {
            self::$crypt_obj = new ComCrypt();
        }
        return self::$crypt_obj->encrypt($text, $salt, 256);
    }
  
    static public function decrypt($text, $salt)
    {
        if (self::$crypt_obj === null)
        {
            self::$crypt_obj = new ComCrypt();
        }
        return self::$crypt_obj->decrypt($text, $salt, 256);
    }
  
    static public function hash256($text)
    {
        return hash('sha256',$text, false);
    }
  
    static public function hash512($text)
    {
        return hash('sha512',$text, false);
    }
    
    static public function crc32($text)
    {
        return hash('crc32',$text, false);
    }
}

?>
