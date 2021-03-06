<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menuController
 *
 * @author ishibkikh
 */
class menuController extends ComPController
{
    public function indexAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Меню');
        ComHTML::h1('Меню');
        ComHTML::append('<table class="table"><tr><th>name</th><th>left top img</th><th>left bottom img</th><th>right img</th></tr>');
        $records = ComDBCommand::getAll('pages', array('offer' => 0));
        foreach ($records as $rec)
        {
            ComHTML::append('<tr><td>'.$rec->title.'</td><td><a onClick="loadForm(\'/cms/architect/editimage/pages/lt_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/pages/ld_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/pages/r_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a href="/cms/menu/edit/'.$rec->id.'"><img src="/img/icons/edit.png" alt="edit" title="Редактировать"></a></td></tr>');
        }
        ComHTML::append('</table>');
        ComHTML::br();
        ComHTML::br();
        ComHTML::append('<p><a href="/cms/countries">Редактировать описание стран</a></p>');
        ComHTML::dispatch();
    }
    
    public function editAction()
    {
        $params = ComRoute::getParams();
        $id = intval($params[0]);
        $rec = ComDBCommand::getRow('pages', array('id' => $id));
        ComHTML::load('cms');
        if (!$rec)
        {
            ComHTML::p('Страница не найдена');
        }
        else
        {
            ComHTML::title($rec->title);
            ComHTML::h1($rec->title);
            $form = new ComForm('menu');
            $form->addElement('content', array('value'=> stripslashes($rec->content)));
            $form->addElement('id', array('type'=>'inputHidden', 'value'=>$id));
            $form->compile();
            ComHTML::setJSCode($form->getJavaScript());
            ComHTML::append($form->getHtml());
        }
        ComHTML::dispatch();
    }
    
    public function submitAction()
    {
        if (!ComWebUser::checkAccess('menu', 'update'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
        $id = intval($_POST['id']);
        $inputs = ComValidator::isValidate($_POST, 'menu');
        if (!$inputs)
        {
            ComResponse::JSON(array('error', $form->getErrors()));
            exit;
        }
        ComDBCommand::update('pages', array('content'=>$inputs['content']), array('id' => $id));
        ComResponse::JSON(array('redirect', '/cms/menu'));
    }
}

?>
