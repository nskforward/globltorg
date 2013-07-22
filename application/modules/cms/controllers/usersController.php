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
                ComHTML::append('<tr><td>'.$rec->title.'</td><td>'.$rec->date_login.'</td><td>'.$state.'</td><td><a href="/cms/roles/'.$rec->id.'">Изменить</a></td><td><a onclick="loadForm(\'/cms/architect/edituser/'.$rec->id.'\');return false;"  href="#"><img alt="редактировать" title="редактировать" src="/img/icons/edit.png"></a></td><td><a onclick="confirmDlg(\'Удалить пользователя ['.$rec->title.']?\',\'/cms/users/delete/'.$rec->id.'\');return false;" href="#"><img alt="удалить" title="удалить" src="/img/icons/remove.png"></a></td></tr>');
            }
            ComHTML::append('</table>');
        }
        ComHTML::br();
        ComHTML::append('<button onclick="loadForm(\'/cms/architect/newuser\');" class="yellow">Создать</button>');
        ComHTML::dispatch();
    }
    
    public function deleteAction()
    {
        $params = ComRoute::getParams();
        $id = intval($params[0]);
        
        if (!ComWebUser::checkAccess('users', 'delete'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
        
        if ($id == ComWebUser::getId())
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'Вы не можете удалить сами себя')));
            return;
        }
        
        if ($id == 1)
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'Вы не можете удалить суперадминистратора')));
            return;
        }
        
        ComDBCommand::delete('users', array('id'=>$id));
        ComResponse::JSON(array('refresh'));
    }
    
    public function createAction()
    {
        if (!ComWebUser::checkAccess('users', 'create'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
        
        $inputs = ComValidator::isValidate($_POST, 'newuser');
        if (!$inputs)
        {
            ComResponse::JSON(array('error', ComValidator::getErrors()));
            return;
        }
        
        $params = array();
        $params['name'] = $inputs['user'];
        $params['title'] = $inputs['title'];
        $params['pass'] = ComSecurity::hash512($inputs['pass']);
        $params['email'] = $inputs['email'];
        $params['role'] = 'member';
        $params['date_reg'] = ComDateTime::getNow();
        $params['block'] = 0;
                        
        ComDBCommand::insert('users', $params);
        ComResponse::JSON(array('refresh'));
    }
    
    
    public function updateAction()
    {
        $params = ComRoute::getParams();
        $id = intval($params[0]);
        $inputs = ComValidator::isValidate($_POST, 'updateuser');
        
        if (!ComWebUser::checkAccess('users', 'update'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
        
        if (!$inputs)
        {
            ComResponse::JSON(array('error', ComValidator::getErrors()));
            return;
        }
        
        if ($inputs['pass'] !== null)
        {
            if ($inputs['pass'] !== $inputs['repass'])
            {
                ComResponse::JSON(array('error', array('repass'=>'Пароли не совпадают')));
                return;
            }
        }
        
        if ($id == 1)
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'Вы не можете редактировать суперадминистратора')));
            return;
        }
       
        $params = array();
        $params['title'] = $inputs['title'];
        $params['email'] = $inputs['email'];
        $params['block'] = $inputs['state'];
        if ($inputs['pass'] !== null)
        {
            $params['pass'] = ComSecurity::hash512($inputs['pass']);
        }
                
        ComDBCommand::update('users', $params, array('id' => $id));
        
        ComResponse::JSON(array('refresh'));
    }
}

?>
