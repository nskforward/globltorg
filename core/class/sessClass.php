<?php

class sessClass
{
    public  $user_name;
    public  $user_id,
            $city_id,
            $user_ip;
    private $status;


  public function __construct()
  {
    session_start();
    If ($_SESSION['user_id'])
    {
        $this->status = true;
        $this->user_id = $_SESSION['user_id'];
        $this->user_name = $_SESSION['user_name'];
        $this->user_ip = $_SESSION['user_ip'];
        If (!$this->checkIP())
        {
            $this->close();
        }
    }
    else
    {
        $this->status = false;
    }
  }
  
  public function create($user_id, $user_name)
  {
    $this->user_name = $user_name;
    $this->user_id = $user_id;
    $this->user_ip = md5($_SERVER['REMOTE_ADDR']);
    session_regenerate_id(1);
    session_write_close();
    session_start();
    $_SESSION['user_ip'] = $this->user_ip;
    $_SESSION['user_name'] = $this->user_name;
    $_SESSION['user_id'] = $this->user_id;
    $this->status = true;
  }
  
  public function close()
  {
    $this->status = false;
    unset($this->user_id);
    unset($this->user_name);
    unset($this->user_ip);
    session_destroy();
  }
  
  public function set($var, $value)
  {
    $_SESSION[$var] = $value;
  }
  
  public function checkIP()
  {
      If ($this->user_ip != md5($_SERVER['REMOTE_ADDR']))
          return false;
      else
          return true;
  }
  
  public function isStart()
  {
    return $this->status;
  }
  
}

?>