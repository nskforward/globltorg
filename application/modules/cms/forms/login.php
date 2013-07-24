<?php

function getFormLogin()
{
    return array(
            'name' => 'login',
            'class' => 'form',
            'action' => 'login/login',
            'submit_title' => 'Вход',
            'description' => 'После 3-х неверных попыток входа, пользователь блокируется на 30 минут в соображении безопасности',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'user' => array(
                    'type' => 'inputText',
                    'label'=> 'Пользователь',
                    'required' => true,
                    'minLength' => 4,
                    'maxLength'=>64,
                    'validator' => 'anum',
                    'formatting' => array('trim')
                    ),
                'pass' => array(
                    'type' => 'inputPassword',
                    'label'=> 'Пароль',
                    'required' => true,
                    'maxLength' => 64
                    )
            )
        );
}


?>
