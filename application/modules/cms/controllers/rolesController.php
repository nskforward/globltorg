<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rolesController
 *
 * @author ishibkikh
 */
class rolesController extends ComPController
{
    public function _autoload($key)
    {
        $id = intval($key);
        ComHTML::load('cms');
        ComHTML::title('Права');
        $user = ComDBCommand::getRow('users', array('id' => $id));
        if (!$user)
        {
            ComHTML::p('Пользователь не найден');
            ComHTML::dispatch();
        }
        ComHTML::h1($user->title);
        $records = ComDBCommand::getAll('access', array('user_id' => $id), 'section');
        if (!$records)
        {
            ComHTML::p('Ни одно правило не назначено');
        }
        else
        {
            ComHTML::append('<table class="table"><tr><th>Секция</th><th>Действие</th><th>Разрешено</th></tr>');
            foreach ($records as $rec)
            {
                $allow = ($rec->allow == 1)?'да':'нет';
                ComHTML::append('<tr><td>'.$rec->section.'</td><td>'.$rec->event.'</td><td>'.$allow.'</td><td><a onclick="confirmDlg(\'Удалить правило ['.$rec->section.' '.$rec->event.']?\',\'/cms/roles/delete/'.$rec->id.'\');return false;" href="#"><img alt="удалить" title="удалить" src="/img/icons/remove.png"></a></td></tr>');
            }
            ComHTML::append('</table>');
        }
        ComHTML::br();
        ComHTML::append('<button onclick="loadForm(\'/cms/architect/newrole/'.$id.'\');" class="yellow">Создать</button>');
        ComHTML::dispatch();
    }
    
    public function createAction()
    {
        if (!ComWebUser::checkAccess('roles', 'create'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
        
        $id = intval($_POST['id']);
        $inputs = ComValidator::isValidate($_POST, 'role');
        if (!$inputs)
        {
            ComResponse::JSON(array('error', ComValidator::getErrors()));
            return;
        }
        
        $params = array();
        $params['section'] = $inputs['section'];
        $params['event'] = $inputs['event'];
        $params['allow'] = $inputs['allow'];
        $params['user_id'] = $id;
        
        $is = ComDBCommand::getRow('access', $params);
        if ($is)
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'Добавляемое правило уже существует')));
            return;
        }
        
        ComDBCommand::insert('access', $params);
        ComResponse::JSON(array('refresh'));
    }
    
    public function deleteAction()
    {
        $params = ComRoute::getParams();
        $id = intval($params[0]);
        
        if (!ComWebUser::checkAccess('roles', 'delete'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
                
        ComDBCommand::delete('access', array('id'=>$id));
        ComResponse::JSON(array('refresh'));
    }
}

?>
