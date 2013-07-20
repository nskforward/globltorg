<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of guestsubmit
 *
 * @author ishibkikh
 */
class guestsubmitController
{
    public function orderAction()
    {
        $inputs = ComValidator::isValidate($_POST, 'order');
        if (!$inputs)
        {
            ComResponse::JSON(array('error', ComValidator::getErrors()));
        }
        else
        {
            $values = array();
            $values[client_name] = $inputs['fio'];
            $values[city_out] = $inputs['city_out'];
            $values[city_in] = $inputs['city_in'];
            $values[night_count] = $inputs['night_count'];
            $values[men_count] = $inputs['men_count'];
            $values[air_class_business] = $inputs['air_class'];
            $values[date_out] = $inputs['date_out'];
            $values[category] = $inputs['category'];
            $values[type] = $inputs['type'];
            $values[insurance] = ($inputs['insurance'])?true:false;
            $values[wishes] = $inputs['wishes'];
            $values[email] = $inputs['email'];
            $values[tel] = $inputs['tel'];
            $id = ComDBCommand::insert('orders', $values);
            
            $m= new ComMail();
            $m->From($inputs['email']);
            $m->To('info@globltorg.com');
            $m->Subject('Заказ тура | Globltorg.com');
            $m->Body('Поступил заказ №'.$id.' от клиента '.$inputs['fio'].'. Просмотреть информацию вы можете в разделе cms - "Заявки"');
            $m->Send();
            
            ComSms::send(ComConfigINI::get('admin_tel'), 'Поступил заказ №'.$id.' от '.$values[client_name]);
                        
            ComResponse::JSON(array('message', array('Заявка создана' =>'Спасибо! В ближайшее время с вами свяжется наш специалист.'), true));
        }
    }
    
    public function callbackAction()
    {
        $inputs = ComValidator::isValidate($_POST, 'callback');
        if (!$inputs)
        {
            ComResponse::JSON(array('error', ComValidator::getErrors()));
        }
        else
        {
            $m= new ComMail();
            $m->From('info@globltorg.com');
            $m->To('info@globltorg.com');
            $m->Subject('Заказ звонка | Globltorg.com');
            $m->Body('Поступила просьба перезвонить клиенту!'.NEWLINE.'Имя: '.$inputs['fio'].NEWLINE.'Телефон: '.$inputs['tel'].NEWLINE.'Тема разговора: '.$inputs['topic'].NEWLINE.'Желаемое время звонка: '.$inputs['clock']);
            $m->Send();

            ComSms::send(ComConfigINI::get('admin_tel'), 'Через форму связи поступила просьба перезвонить клиенту '.$inputs['tel']);
                        
            ComResponse::JSON(array('message', array('Заявка создана' =>'Спасибо! В ближайшее время с вами свяжется наш специалист.'), true));
        }
    }
    
    public function feedbackAction()
    {
        $inputs = ComValidator::isValidate($_POST, 'feedback');
        if (!$inputs)
        {
            ComResponse::JSON(array('error', ComValidator::getErrors()));
        }
        else
        {
            $m= new ComMail();
            $m->From('info@globltorg.com');
            $m->To('info@globltorg.com');
            $m->Subject('Задан вопрос | Globltorg.com');
            $m->Body('Имя: '.$inputs['fio'].NEWLINE.'Вопрос: '.$inputs['body']);
            $m->Send();

            ComSms::send(ComConfigINI::get('admin_tel'), 'Задан вопрос через форму связи. Ответьте клиенту '.$inputs['fio']);
                        
            ComResponse::JSON(array('message', array('Заявка создана' =>'Спасибо! В ближайшее время с вами свяжется наш специалист.'), true));
        }
    }
}

?>
