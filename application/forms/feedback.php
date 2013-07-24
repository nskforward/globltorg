<?php

function getFormFeedback()
{
    return array(
            'name' => 'feedback',
            'class' => 'form',
            'action' => 'guestsubmit/feedback',
            'submit_title' => 'Заказать',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'fio' => array(
                    'type' => 'inputText',
                    'label'=> 'Ваше имя',
                    'required' => true,
                    'minLength' => 3,
                    'maxLength'=>100,
                    'validator' => 'alphastrings',
                    'formatting' => array(
                        'trim',
                        'upperfirstletters'
                        )
                    ),
                'email' => array(
                    'type' => 'inputText',
                    'label'=> 'Контактный E-mail',
                    'required' => true,
                    'maxLength'=>128,
                    'validator' => 'email'
                ),
                'body' => array(
                    'type' => 'inputText',
                    'label'=> 'Вопрос',
                    'required' => true,
                    'minLength' => 10,
                    'maxLength' => 1000
                    ),
                'captcha' => array(
                    'type' => 'captcha',
                    'label'=> 'Код с картинки',
                    'required' => true,
                    'maxLength'=>10
                )
            )
        );
}


?>
