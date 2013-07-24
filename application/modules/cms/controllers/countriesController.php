<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of countriesController
 *
 * @author ishibkikh
 */
class countriesController extends ComPController
{     
    public function indexAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Континенты');
        ComHTML::h1('Континенты');
        ComHTML::append('<table class="table"><tr><th>name</th><th>left top img</th><th>left bottom img</th><th>right img</th></tr>');
        $records = ComDBCommand::getAll('continents');
        foreach ($records as $rec)
        {
            ComHTML::append('<tr><td><a href="/cms/countries/country/'.$rec->id.'">'.$rec->title.'</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/continent/lt_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/continent/ld_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/continent/r_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a href="/cms/countries/editcontinent/'.$rec->id.'"><img src="/img/icons/edit.png" alt="edit" title="Редактировать"></a></td></tr>');
        }
        ComHTML::append('</table>');
        ComHTML::dispatch();
    }
    
    public function editcontinentAction()
    {
        $params = ComRoute::getParams();
        $id = intval($params[0]);
        $rec = ComDBCommand::getRow('continents', array('id' => $id));
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
            $form->editAction('/cms/countries/submitcontinent');
            $form->editCancel('/cms/countries');
            $form->addElement('content', array('value'=> stripslashes($rec->content)));
            $form->addElement('id', array('type'=>'inputHidden', 'value'=>$id));
            $form->compile();
            ComHTML::setJSCode($form->getJavaScript());
            ComHTML::append($form->getHtml());
        }
        ComHTML::dispatch();
    }
    
    public function editcountryAction()
    {
        $params = ComRoute::getParams();
        $id = intval($params[0]);
        $rec = ComDBCommand::getRow('places_tour', array('id' => $id));
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
            $form->editAction('/cms/countries/submitcountry');
            $form->editCancel('/cms/countries/country/'.$rec->parent_id);
            $form->addElement('content', array('value'=> stripslashes($rec->content)));
            $form->addElement('id', array('type'=>'inputHidden', 'value'=>$id));
            $form->compile();
            ComHTML::setJSCode($form->getJavaScript());
            ComHTML::append($form->getHtml());
        }
        ComHTML::dispatch();
    }

    
    public function submitcontinentAction()
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
            return;
        }
        ComDBCommand::update('continents', array('content'=>$inputs['content']), array('id' => $id));
        ComResponse::JSON(array('redirect', '/cms/countries'));
    }
    
    public function submitcountryAction()
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
            return;
        }
        ComDBCommand::update('places_tour', array('content'=>$inputs['content']), array('id' => $id));
        ComResponse::JSON(array('redirect', '/cms/countries'));
    }
    
    public function countryAction()
    {
        $params = ComRoute::getParams();
        $id = intval($params[0]);
        ComHTML::load('cms');
        ComHTML::title('Страны');
        ComHTML::p('<a href="/cms/countries">Назад</a>');
        ComHTML::h1('Страны');
        ComHTML::append('<table class="table"><tr><th>name</th><th>left top img</th><th>left bottom img</th><th>right img</th></tr>');
        $records = ComDBCommand::getAll('places_tour', array('parent_id' => $id));
        foreach ($records as $rec)
        {
            ComHTML::append('<tr><td>'.$rec->title.'</td><td><a onClick="loadForm(\'/cms/architect/editimage/country/lt_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/country/ld_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/country/r_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a href="/cms/countries/editcountry/'.$rec->id.'"><img src="/img/icons/edit.png" alt="edit" title="Редактировать"></a></td></tr>');
        }
        ComHTML::append('</table>');
        ComHTML::dispatch();
    }
}

?>
