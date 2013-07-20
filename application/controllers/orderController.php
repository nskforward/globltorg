<?php

/* * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Home page | 1.0.0 * 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
 If ($this->method != 'POST')
  {
      $this->setContentType('html');
      $this->setTitle('Заказ путешествия');
      $this->loadMainTemplate(1);
      $this->setVar('BODY', '<h1>Персональный подбор туров</h1><!--[ORDER]-->');
      $this->content = $this->template->setForm($this->content);
      $this->setLSBar("order_1.jpg", "order_2.jpg");
      $this->setRSBar("order_3.jpg");
      $this->setResponse();
  }
  else
  {
      $this->setContentType('json');
      $validator = new validatorClass($this->page);
      $validator->loadParams($this->post);
      if ($validator->isError == false)
      {
         $db = new dbClass('orders'); 
         $values = $db->getFieldsArray();
         $values['client_name']         = trim($this->post['fio']);
         $values['city_out']            = $this->post['city_out'];
         $values['city_in']             = $this->post['city_in'];
         $values['night_count']         = intval($this->post['night_count']);
         $values['men_count']           = intval($this->post['men_count']);
         $values['air_class_business']  = intval($this->post['air_class']);
         $values['date_out']            = $db->date($this->post['date_out_d'],$this->post['date_out_m'],$this->post['date_out_y']);
         $values['category']            = intval($this->post['category']);
         $values['type']                = intval($this->post['type']);
         If ($this->post['insurance']) $values['insurance'] = true;
         $values['wishes']              = htmlentities(trim($this->post['wishes']), ENT_QUOTES, "UTF-8");
         $values['email']               = $this->post['email'];
         $values['tel']                 = strval($this->post['tel']);
         $res = $db->insert($values);
         $id_row = $db->insert_id();
         require_once(PATH."emailClass.php");
         $m= new Mail;
         $m->From($this->post['email']);
         $m->To($this->config->support_email);
         $m->Subject('GloblTorg | Order Form');
         $m->Body('Поступил заказ №'.$id_row.' от клиента '.$values['client_name'].'.
Просмотреть информацию вы можете в разделе cms - "Заявки"');
         $m->Priority(3);
         //$m->smtp_on("smtp.asd.com", "login", "password");
         $m->Send();
         $this->setResponse(rjson('success', ''), 0);
      }
      else
      {
        $this->setResponse(rjson('error', $validator->errorText), 0);
      }
  }
?>
