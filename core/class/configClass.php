<?php
class configClass
{
  private $now_regim;
  private $config;
    
  public function __construct($path)
   {
     If (!file_exists($path)) throw new CustomException('Config file not found');
     $this->config = parse_ini_file($path, true);
     define('PATH',str_replace("\\","/",dirname( __FILE__ ))."/");
     If ($this->config['now']['production']=='1')$this->now_regim='production';
     else $this->now_regim='development';
   }

  public function __get($property)
  {
     if (isset($this->config[$this->now_regim][$property]))
         {
            return $this->config[$this->now_regim][$property];
         }
     else
         {
            throw new CustomException('Property "'.$property.'" not found');
            return false;
         }
  }
}

?>
