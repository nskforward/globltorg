<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Log In page | 1.0.0   * 
 * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
 if ($this->method != 'POST')
 {
    $this->setContentType('html');
    $this->setTitle('Авторизация');
    $this->content = $this->template->load("login");
    $this->setLSBar("login_1.jpg", null);
    $this->setResponse();
 }
 else
 {
   $this->setContentType('json');
   $validForm = new validatorClass($this->page);
   $validForm->loadParams($this->post);
   if ($validForm->isError == false)
     {
       $db = new dbClass('users');
       $user = $db->isLogin('name', 'pass', $this->post['user'], $this->post['pass']);
       If ($user == FALSE)
        {
          $this->setResponse(rjson('error', "Неверное имя пользователя или пароль"), 0);
        }  
       else 
        {
          $db->updateValue($user->id, "date_login", $db->now());
          $this->sess->create(intval($user->id), $user->title);
          $this->setResponse(rjson('redirect', "/cms"), 0);
        }
     }
   else
     {
       $this->setResponse(rjson('text', $validForm->errorText), 0);
     }   
 }
?>
