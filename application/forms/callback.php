<?php

function getFormCallback()
{
    return array(
            'name' => 'callback',
            'class' => 'form',
            'action' => 'guestsubmit/callback',
            'submit_title' => 'Заказать',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'fio' => array(
                    'type' => 'text',
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
                'tel' => array(
                    'type' => 'text',
                    'label'=> 'Контактный телефон (с кодом)',
                    'validator' => 'phone',
                    'required' => true,
                    'maxLength' => 100
                    ),
                'topic' => array(
                    'type' => 'text',
                    'label'=> 'Коротко о теме разговора',
                    'required' => true,
                    'maxLength' => 1000,
                    'formatting' => array('trim')
                    ),
                'clock' => array(
                    'type' => 'text',
                    'label'=> 'Когда позвонить?',
                    'maxLength'=>64,
                    'validator' => 'custom',
                    'formatting' => array('trim')
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
