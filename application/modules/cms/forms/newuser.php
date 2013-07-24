<?php

function getFormNewuser()
{
    return array(
            'name' => 'userform',
            'class' => 'form',
            'action' => '/cms/users/create',
            'submit_title' => 'Создать',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'title' => array(
                    'type' => 'inputText',
                    'label'=> 'Имя Фамилия',
                    'required' => true,
                    'minLength' => 4,
                    'maxLength'=>64,
                    'validator' => 'alphastrings',
                    'formatting' => array('trim', 'upperfirstletters')
                    ),
                'user' => array(
                    'type' => 'inputText',
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
                    'type' => 'inputText',
                    'label'=> 'E-mail',
                    'required' => true,
                    'minLength' => 4,
                    'maxLength'=>32,
                    'validator' => 'email'
                    ),
                'pass' => array(
                    'type' => 'inputPassword',
                    'label'=> 'Новый пароль',
                    'required' => true,
                    'maxLength' => 64
                    ),
                'repass' => array(
                    'type' => 'inputPassword',
                    'label'=> 'Повтор пароля',
                    'required' => true,
                    'maxLength' => 64,
                    'conformity' => 'pass'
                    )
            )
        );
}


?>
