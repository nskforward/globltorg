<?php
  class CustomException extends Exception
  {

    public function __construct($message)
    {
      parent::__construct($message);
      
      If (DISPLAY_ERRORS == '1')
          $this->show_error_debug();
      else
          $this->show_error_private();
    }

      protected function show_error_private()
    {
    require_once('../application/templates/fatalerrorTemplate.tpl');
    //
    //$this->send_to_admin();
    }

    protected function show_error_debug()
    {
     echo '<h1>APP ERROR</h1><p><b>'.$this->getMessage().'</b></p>';
     echo '<p>'.$this->getFile().'</p>';
     echo '<p>line: '.$this->getLine().'</p>';
     //$this->send_to_admin();
    }
/*
    protected function send_to_admin()
    {
      require_once('sendmail.php');
      $name_from = 'Hi100|System';
      $email_from = 'info@hi100.ru';
      $name_to = 'Администратор системы Hi100.Ru';
      $email_to = ADMIN_EMAIL;
      $subject = 'FATAL ERROR';
      $body = $this->getMessage().'  in '.$this->getFile().'  in '.$this->getLine();

      $sys = new SystemParams('../config.ini');
      If ($sys->read('now','production','100') == '0') $now = 'development';
      else $now = 'production';
      If ($sys->read($now,'critical_error','100') == 0)
       send_mime_mail($name_from, // имя отправителя
                        $email_from, // email отправителя
                        $name_to, // имя получателя
                        $email_to, // email получателя
                        $subject, // тема письма
                        $body   // текст письма
                        );
      $sys->write($now,'critical_error',1);
      $sys->updateFile();
    }
 * 
 */
  }
?>