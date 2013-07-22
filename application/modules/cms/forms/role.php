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
                    'type' => 'list',
                    'label'=> 'Секция',
                    'required' => true,
                    'items' => array(
                        'banners' => 'banners',
                        'courses' => 'courses',
                        'images' => 'images',
                        'menu' => 'menu',
                        'offers' => 'offers',
                        'orders' => 'orders',
                        'roles' => 'roles',
                        'users' => 'users'
                        ),
                    'validator' => 'anum'
                    ),
                'event' => array(
                    'type' => 'list',
                    'label'=> 'Действие',
                    'required' => true,
                    'validator' => 'anum',
                    'items' => array(
                        'update' => 'update',
                        'delete' => 'delete',
                        'create' => 'create'
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
