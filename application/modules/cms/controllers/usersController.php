<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usersController
 *
 * @author ivan
 */
class usersController extends ComPController
{
    public function indexAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Управление пользователями');
        ComHTML::h1('Пользователи');
        $records = ComDBCommand::getAll('users');
        if (!$records)
        {
            ComHTML::p('Пользователи не найдены');
        }
        else
        {
            ComHTML::append('<table class="table"><tr><th>Имя</th><th>Последний вход</th><th>Состояние</th><th>Права</th></tr>');
            foreach ($records as $rec)
            {
                $state = ($rec->block == 0)?'активный':'блокирован';
                ComHTML::append('<tr><td>'.$rec->title.'</td><td>'.$rec->date_login.'</td><td>'.$state.'</td><td><a href="/cmc/">Изменить</a></td><td><a href="/cms/"><img alt="редактировать" title="редактировать" src="/img/icons/edit.png"></a></td><td><a href="/cms/"><img alt="удалить" title="удалить" src="/img/icons/remove.png"></a></td></tr>');
            }
            ComHTML::append('</table>');
        }
        ComHTML::br();
        ComHTML::append('<button class="yellow">Создать</button>');
        ComHTML::dispatch();
    }
}

?>
