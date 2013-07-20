<?php

function getFormOffer()
{
    return array(
            'name' => 'offer',
            'class' => 'form',
            'action' => '/cms/newoffer/submit',
            'submit_title' => 'Создать',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'title' => array(
                    'type' => 'text',
                    'label'=> 'Название',
                    'required' => true,
                    'minLength' => 4,
                    'maxLength'=>64,
                    'validator' => 'alphastrings',
                    'formatting' => array('trim')
                    ),
                'state' => array(
                    'type' => 'radio',
                    'label'=> 'Состояние',
                    'position'=>'hor',
                    'items' => array(
                        '0' => 'Выключен',
                        '1' => 'Включен'
                    ),
                    'selected' => '1'
                    ),
                'url' => array(
                  'type' => 'text',
                  'label'=> 'url',
                  'minLength' => 4,
                  'maxLength'=>20,
                  'required' => true,
                  'validator' => 'anum'
                ),
                'content' => array(
                    'type' => 'textarea',
                    'label'=> 'Контент',
                    'id' => 'jseditor',
                    'minLength' => 4,
                    'maxLength'=>10000
                    )
            )
        );
}


?>
