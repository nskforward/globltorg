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
        sideBar::render('login_1.jpg', null, null);
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
            return;
        }
        
        $row = ComDBCommand::getRow('users', array('name' => $inputs['user']));
        if (!$row)
        {
            ComResponse::JSON(array('error', array('user'=>'Пользователь не зарегистрирован')));
            return;
        }
        
        if ($row->block == 1)
        {
            ComResponse::JSON(array('error', array('user'=>'Пользователь заблокирован')));
            return;
        }
            
        if (ComSecurity::hash512($inputs['pass']) != $row->pass)
        {
            ComResponse::JSON(array('error', array('pass'=>'Неверный пароль')));
            return;
        }
  
        ComWebUser::registry($row->id, $row->title, $row->role, false);
        ComDBCommand::update('users', array('date_login' => ComDateTime::getNow()), array('id' => $row->id));
        ComResponse::JSON(array('redirect', '/cms/'));
   }
}

?>
