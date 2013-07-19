<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offersController
 *
 * @author ishibkikh
 */
class offersController extends ComPController
{
    public function indexAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Спецпредложения');
        ComHTML::h1('Спецпредложения');
        $records = ComDBCommand::getAll('pages', array('offer' => 1), 'id', true);
        ComHTML::append('<table class="table">');
        ComHTML::append('<tr><th>name</th><th>left top img</th><th>left bottom img</th><th>right img</th><th>state</th></tr>');
        foreach ($records as $rec)
        {
            $active = ($rec->active == 1)?'<a href="#" onclick="confirmDlg(\'Выключить?\', \'/cms/processing/activatepage/'.$rec->id.'/0\');return false;"><span class="green"><b>Вкл</b></span></a>':'<a href="#" onclick="confirmDlg(\'Включить?\', \'/cms/processing/activatepage/'.$rec->id.'/1\');return false;"><span class="red"><b>Выкл</b></span></a>';
            ComHTML::append('<tr><td><a onclick="inputDlg(\'Название спецпредложения\', \''.$rec->title.'\', \'/cms/processing/updatetitle/pages/'.$rec->id.'\');return false;" href="#">'.$rec->title.'</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/pages/lt_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/pages/ld_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td><a onClick="loadForm(\'/cms/architect/editimage/pages/r_sb/'.$rec->id.'\'); return false;" href="#">Просмотр</a></td><td>'.$active.'</td><td><a href="/cms/offer/'.$rec->id.'"><img src="/img/icons/edit.png" alt="edit" title="Редактировать"></a></td><td><a href="#" onclick="confirmDlg(\'Удалить страницу ['.$rec->title.']?\',\'/cms/processing/deleteoffer/'.$rec->id.'\');return false;"><img src="/img/icons/remove.png" alt="remove" title="Удалить"></a></td></tr>');
        }
        ComHTML::append('</table>');
        ComHTML::br();
        ComHTML::append('<a href="/cms/newoffer"><button class="yellow">Создать</button></a>');
        ComHTML::dispatch();
    }
}

?>
