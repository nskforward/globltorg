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
                        'banners' => 'Баннеры',
                        'courses' => 'Курсы',
                        'images' => 'Картинки',
                        'menu' => 'Меню',
                        'offers' => 'Спецпредложения',
                        'orders' => 'Заявки',
                        'roles' => 'Права',
                        'users' => 'Пользователи'
                        ),
                    'validator' => 'anum'
                    ),
                'event' => array(
                    'type' => 'list',
                    'label'=> 'Действие',
                    'required' => true,
                    'validator' => 'anum',
                    'items' => array(
                        'update' => 'Обновление',
                        'delete' => 'Удаление',
                        'create' => 'Создание'
                        )
                    ),
                'allow' => array(
                    'type' => 'checkbox',
                    'label'=> 'Доступ',
                    'title' => 'разрешить',
                    'selected' => true
                )
            )
        );
}


?>
