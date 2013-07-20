<?php

$this->setContentType('json');
$json = array('type'=> 'error', 'value' => 'no content');

switch ($this->params[1])
 {
    case "feedback" :
      $validator = new validatorClass($this->params[1]);
      $validator->loadParams($this->post);
      if ($validator->isError == false)
      {
          $question = trim($this->post['body']);
          $user = trim($this->post['fio']);
          $email = $this->post['email'];
          require_once(PATH."emailClass.php");
          $m= new Mail;
          $m->From($email);
          $m->To('info@globltorg.com');
          $m->Subject('GloblTorg | Задан вопрос');
          $m->Body('Срочно ответьте клиенту!
Имя: '.$user.'
Email: '.$email.'
Вопрос: '.$question);
         $m->Priority(3);
         //$m->smtp_on("smtp.asd.com", "login", "password");
         $m->Send();
         $json = array('type'=> 'success', 'value' => 'Спасибо! Ваша заявка принята. Ожидайте ответ');
      }
      else
      {
          $json = array('type'=> 'error', 'value' => $validator->errorText);
      }
      break;
    
    case "callback" :
      $validator = new validatorClass($this->params[1]);
      $validator->loadParams($this->post);
      if ($validator->isError == false)
      {
          $user = trim($this->post['fio']);
          $tel = trim($this->post['tel']);
          $topic = trim($this->post['topic']);
          $clock = trim($this->post['clock']);
          require_once(PATH."emailClass.php");
          $m= new Mail;
          $m->From('noreply@globltorg.com');
          $m->To('info@globltorg.com');
          $m->Subject('GloblTorg | Заказ звонка');
          $m->Body('Срочно перезвоните клиенту!
Имя: '.$user.'
Телефон: '.$tel.'
Тема: '.$topic.'
Желаемое время звонка (может быть пустым): '.$clock);
         $m->Priority(3);
         //$m->smtp_on("smtp.asd.com", "login", "password");
         $m->Send();
         $json = array('type'=> 'success', 'value' => 'Спасибо! Ваша заявка принята. Ожидайте звонка.');
      }
      else
      {
          $json = array('type'=> 'error', 'value' => $validator->errorText);
      }
      break;
    
 }

$this->setResponse(json_encode($json), 0);
?>
