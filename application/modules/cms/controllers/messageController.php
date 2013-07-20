<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of messageController
 *
 * @author ishibkikh
 */
class messageController
{
    public function _autoload($key)
    {
        $id = intval($key);
        ComHTML::load('cms');
        ComHTML::title('Отправка письма');
        $rec = ComDBCommand::getRow('orders', array('id' => $id));
        if (!$rec)
        {
            ComHTML::p('Заявка не найдена');
        }
        else
        {
            ComHTML::h1('Ответ на E-mail');
            ComHTML::append('<form name="message" class="form"><table>');
            ComHTML::append('<tr><td>Кому:</td><td><b>'.$rec->email.'</b></td></tr>');
            ComHTML::append('<tr><td>От:</td><td><b>info@globltorg.com</b></td></tr>');
            ComHTML::append('<tr><td>Тема:</td><td><b>Ответ на заявку №'.$rec->id.' в турагентство "Глоблторг"</b></td></tr>');
            ComHTML::append('<tr><td>Письмо:</td><td><textarea name="body">Здравствуйте, '.$rec->client_name.','.NEWLINE.'С вашего E-mail адреса поступила заявка ('.$rec->city_in.')'.NEWLINE.'Готовы вам предложить следующее:'.NEWLINE);
            ComHTML::append(NEWLINE.'<<-- ВСТАВТЕ СВОЙ ТЕКСТ -->>'.NEWLINE);
            ComHTML::append('С уважением,'.NEWLINE.ComWebUser::getName().NEWLINE.'Специалист по работе с клиентами'.NEWLINE.'Туристические услуги'.NEWLINE.'www.globltorg.com'.NEWLINE.'+7(925)825-2775'.NEWLINE);
            ComHTML::append(NEWLINE.'Важно! Пожалуйста, сохраняйте в ответных письмах историю переписки и номер заявки в заголовке письма. Это ускорит наш ответ. Заранее спасибо!</textarea></td></tr>');
            ComHTML::append('<tr><td></td><td><button onclick="checkForm(\'message\', \'/cms/message/submit\'); return false;">Отправить</button></td></tr>');
            ComHTML::append('<input name="id" type="hidden" value="'.$rec->id.'">');
            ComHTML::append('</table></form>');
        }
        ComHTML::dispatch();
    }
    
    public function submitAction()
    {
        $body = stripslashes($_POST['body']);
        $id = intval($_POST['id']);
        $rec = ComDBCommand::getRow('orders', array('id' => $id));
        if (!$rec)
        {
            ComResponse::JSON(array('message', array('error'=>'Заявка не найдена')));
            exit;
        }
        
        $m= new ComMail();
        $m->From('info@globltorg.com');
        $m->To($rec->email);
        $m->Subject('Ответ на заявку №'.$rec->id.' в турагентство "Глоблторг"');
        $m->Body($body);
        $m->Send();
        ComResponse::JSON(array('redirect', '/cms/orders'));
    }
}

?>
