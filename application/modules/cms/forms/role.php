<?php

function getFormRole()
{
    return array(
            'name' => 'roleform',
            'class' => 'form',
            'action' => '/cms/roles/create',
            'submit_title' => 'Создать',
            'header' => 'Новое правило',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'section' => array(
                    'type' => 'text',
                    'label'=> 'Секция',
                    'required' => true,
                    'minLength' => 2,
                    'maxLength'=> 32,
                    'validator' => 'anum',
                    'formatting' => array('trim', 'lowercase')
                    ),
                'event' => array(
                    'type' => 'list',
                    'label'=> 'Действие',
                    'required' => true,
                    'items' => array(
                        'update' => 'update',
                        'delete' => 'delete',
                        'create' => 'create',
                        'view' => 'view'
                        )
                    ),
                'allow' => array(
                    'type' => 'checkbox',
                    'label'=> 'Доступ',
                    'title' => 'разрешить',
                    'value' => true
                )
            )
        );
}


?>
