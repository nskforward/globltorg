<?php

function getFormUpdateuser()
{
    return array(
            'name' => 'userform',
            'class' => 'form',
            'action' => 'users/update',
            'submit_title' => 'Обновить',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'title' => array(
                    'type' => 'text',
                    'label'=> 'Имя Фамилия',
                    'required' => true,
                    'minLength' => 4,
                    'maxLength'=>64,
                    'validator' => 'alphastrings',
                    'formatting' => array('trim', 'upperfirstletters')
                    ),
                'email' => array(
                    'type' => 'text',
                    'label'=> 'E-mail',
                    'required' => true,
                    'minLength' => 4,
                    'maxLength'=>32,
                    'validator' => 'email'
                    ),
                'pass' => array(
                    'type' => 'password',
                    'label'=> 'Новый пароль',
                    'required' => false,
                    'maxLength' => 64
                    ),
                'repass' => array(
                    'type' => 'password',
                    'label'=> 'Повтор пароля',
                    'required' => false,
                    'maxLength' => 64,
                    'conformity' => 'pass'
                    ),
                'state' => array(
                    'type' => 'radio',
                    'label'=> 'Состояние',
                    'position'=>'h',
                    'items' => array(
                      '0' => 'активный',
                      '1' => 'блокиронный',
                    )
                    ),
                'reg' => array(
                    'type' => 'print',
                    'label'=> 'Дата регистрации'
                    )
            )
        );
}


?>
