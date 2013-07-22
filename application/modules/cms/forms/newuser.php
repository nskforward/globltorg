<?php

function getFormNewuser()
{
    return array(
            'name' => 'userform',
            'class' => 'form',
            'action' => 'users/create',
            'submit_title' => 'Создать',
            'header'=>'Новый пользователь',
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
                'user' => array(
                    'type' => 'text',
                    'label'=> 'Логин',
                    'required' => true,
                    'minLength' => 4,
                    'maxLength'=>32,
                    'validator' => 'anum',
                    'unique'=> array(
                      'table' => 'users',
                      'field' => 'name'
                    ),
                    'formatting' => array('trim', 'lowercase')
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
                    'required' => true,
                    'maxLength' => 64
                    ),
                'repass' => array(
                    'type' => 'password',
                    'label'=> 'Повтор пароля',
                    'required' => true,
                    'maxLength' => 64,
                    'conformity' => 'pass'
                    )
            )
        );
}


?>
