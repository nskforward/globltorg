<?php

class ComSession
{
  static private $status;
  
  static public function init()
  {
      session_name('SID');
      session_save_path(PATH.'data/sessions');
      if ($_COOKIE[session_name()])
      {
        session_start();
        if (self::get('user_id'))
        {
            self::$status = true;
            If (!self::check())
            {
                self::destroy();
            }
        }
        else
        {
            self::$status = false;
        }
      }
      else
      {   
           self::$status = false;
      }
  }
 
  static public function create($user_id, $user_name, $lifetime=0)
  {
    if (self::$status) throw new SysException('Session already started');
    if (($user_id !== NULL)and($user_name !== Null))
    {
        session_set_cookie_params($lifetime);
        session_start();
        session_regenerate_id(true);
        self::$status = true;
        self::set('user_id', $user_id);
        self::set('user_name', $user_name);
        self::set('user_fp', ComSecurity::hash256($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
    }
    else
    {
        throw new SysException('Session can not be started because 1 or both input parameters is empty');
    }
  }
  
  
  static public function delete($name)
  {
      unset($_SESSION[$name]);
  }
  
  static public function destroy()
  {
    self::$status = false;
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
  }
  
  static public function check()
  {
      If (self::get('user_fp') != ComSecurity::hash256($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))
          return false;
      else
          return true;
  }
  
  static public function set($name, $value)
  {
    $_SESSION[$name] = $value;
  }
  
  static public function getId()
  {
      return self::get('user_id');
  }
  
  static public function getName()
  {
      return self::get('user_name');
  }

    static public function get($name) 
  {
    return $_SESSION[$name];
  }
  
  static public function isActive()
  {
    return self::$status;
  }
  
}

?>