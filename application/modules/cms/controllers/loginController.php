<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginController
 *
 * @author ishibkikh
 */
class loginController
{
    public function indexAction()
    {
        ComHTML::load('login');
        ComHTML::title('Авторизация');
        ComHTML::dispatch();
    }
    
    public function logoutAction()
    {
        ComWebUser::destroy();
        ComResponse::redirect('/cms');
    }
    
    public function loginAction()
    {
        $inputs = ComValidator::isValidate($_POST, 'login');
        if (!$inputs)
        {
            ComResponse::JSON(array('error', ComValidator::getErrors()));
        }
        else
        {
            $row = ComDBCommand::getRow('users', array('name' => $inputs['user']));
            if (!$row)
            {
                ComResponse::JSON(array('error', array('user'=>'Пользователь не зарегистрирован')));
            }
            else
            {
                if (ComSecurity::hash512($inputs['pass']) != $row->pass)
                {
                    ComResponse::JSON(array('error', array('pass'=>'Неверный пароль')));
                }
                else
                {
                    ComWebUser::registry($row->id, $row->title, $row->role, false);
                    ComResponse::JSON(array('redirect', '/cms/'));
                }
            }
        }
    }
}

?>
