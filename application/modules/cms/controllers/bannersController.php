<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bannersController
 *
 * @author ishibkikh
 */
class bannersController extends ComPController
{
    public function indexAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Баннеры');
        ComHTML::h1('Большие баннеры');
        $records = ComDBConnection::query('select f.title, f.id, f.active, p.title as link, p.url, p.offer from index_frame f, pages p where link_id = p.id order by f.id desc');
        ComHTML::append('<table class="table">');
        ComHTML::append('<tr><th>Название</th><th>Картинка</th><th>Ссылка на</th><th>Состояние</th></tr>');
        foreach ($records as $rec)
        {
            $active = ($rec->active == 1)?'<a href="#" onclick="confirmDlg(\'Выключить?\', \'/cms/processing/activatebann/big/'.$rec->id.'/0\');return false;"><span class="green"><b>Вкл</b></span></a>':'<a href="#" onclick="confirmDlg(\'Включить?\', \'/cms/processing/activatebann/big/'.$rec->id.'/1\');return false;"><span class="red"><b>Выкл</b></span></a>';
            ComHTML::append('<tr><td><a onclick="inputDlg(\'Название баннера\', \''.$rec->title.'\', \'/cms/processing/updatetitle/big/'.$rec->id.'\');return false;" href="#">'.$rec->title.'</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/big/src/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onclick="loadForm(\'/cms/architect/getlinks/big/'.$rec->id.'\');return false;" href="#">'.$rec->link.'</a></td><td>'.$active.'</td><td><a href="#" onclick="confirmDlg(\'Удалить баннер ['.$rec->title.']?\',\'/cms/processing/deletebanner/big/'.$rec->id.'\');return false;"><img src="/img/icons/remove.png" title="удалить" alt="remove"></a></td></tr>');
        }
        ComHTML::append('</table>');
        ComHTML::br();
        ComHTML::append('<a href="/cms/banners/newbig"><button class="yellow">Создать</button></a>');
        
        ComHTML::h1('Маленькие баннеры');
        $records = ComDBConnection::query('select f.title, f.id, f.active, p.title as link, p.url, p.offer from index_baner f, pages p where link_id = p.id');
        ComHTML::append('<table class="table">');
        ComHTML::append('<tr><th>Название</th><th>Картинка</th><th>Ссылка на</th><th>Состояние</th></tr>');
        foreach ($records as $rec)
        {
            $active = ($rec->active == 1)?'<a href="#" onclick="confirmDlg(\'Выключить?\', \'/cms/processing/activatebann/small/'.$rec->id.'/0\');return false;"><span class="green"><b>Вкл</b></span></a>':'<a href="#" onclick="confirmDlg(\'Включить?\', \'/cms/processing/activatebann/small/'.$rec->id.'/1\');return false;"><span class="red"><b>Выкл</b></span></a>';
            ComHTML::append('<tr><td><a onclick="inputDlg(\'Название баннера\', \''.$rec->title.'\', \'/cms/processing/updatetitle/small/'.$rec->id.'\');return false;" href="#">'.$rec->title.'</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/small/src/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onclick="loadForm(\'/cms/architect/getlinks/small/'.$rec->id.'\');return false;" href="#">'.$rec->link.'</a></td><td>'.$active.'</td><td><a href="#" onclick="confirmDlg(\'Удалить баннер ['.$rec->title.']?\',\'/cms/processing/deletebanner/small/'.$rec->id.'\');return false;"><img src="/img/icons/remove.png" title="удалить" alt="remove"></a></td></tr>');
        }
        ComHTML::append('</table>');
        ComHTML::br();
        ComHTML::append('<a href="/cms/banners/newsmall"><button class="yellow">Создать</button></a>');
        ComHTML::dispatch();
    }
    
    public function newbigAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Большой баннер');
        ComHTML::h1('Новый большой баннер');
        $form = new ComForm('banner');
        $records = ComDBCommand::getAll('pages', array('offer'=>1));
        foreach ($records as $rec)
        {
            $form->addListItem('link', $rec->id, $rec->title);
        }
        $form->addElement('type', array('type'=>'hidden','value'=>'big'));
        $form->compile();
        ComHTML::setJSCode($form->getJavaScript());
        ComHTML::append($form->getHtml());
        ComHTML::dispatch();
    }
    
    public function newsmallAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Маленький баннер');
        ComHTML::h1('Новый маленький баннер');
        $form = new ComForm('banner');
        $records = ComDBCommand::getAll('pages', array('offer'=>1));
        foreach ($records as $rec)
        {
            $form->addListItem('link', $rec->id, $rec->title);
        }
        $form->addElement('type', array('type'=>'hidden','value'=>'small'));
        $form->compile();
        ComHTML::setJSCode($form->getJavaScript());
        ComHTML::append($form->getHtml());
        ComHTML::dispatch();
    }
    
    public function submitAction()
    {
        $inputs = ComValidator::isValidate($_POST, 'banner');
        if (!$inputs)
        {
            ComResponse::JSON(array('error', $form->getErrors()));
            exit;
        }
        $table = ($_POST['type'] == 'big')?'index_frame':'index_baner';
        $array = (array)$_POST['uploads'];
        $uploaded_img = PATH.'data/upload/'.$array[0];
        $path_parts = pathinfo($uploaded_img);
        $ext = $path_parts['extension'];
        $timestamp = time();
        $new_name = 'img_'.$timestamp.'.'.$ext;
        $new_img = PATH.'public/img/'.$new_name;
        rename($uploaded_img, $new_img);
        $values = array();
        $values['id'] = NULL;
        $values['title'] = $inputs['title'];
        $values['link_id'] = intval($inputs['link']);
        $values['src'] = $new_name;
        $values['active'] = intval($inputs['state']);
        ComDBCommand::insert($table, $values);
        ComCacheFile::delete('index'.'index');
        ComResponse::JSON(array('redirect', '/cms/banners'));
    }
}

?>
