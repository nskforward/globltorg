<?php

function getFormOrder()
{
    return array(
            'name' => 'order',
            'description' => 'Поля без знака <em>*</em> можно оставить пустые',
            'class' => 'form',
            'action' => 'guestsubmit/order',
            'submit_title' => 'Подобрать',
            'cancel_url' => '/offers',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'fio' => array(
                    'type' => 'inputText',
                    'label'=> 'Ваше Ф.И.О.',
                    'required' => true,
                    'minLength' => 3,
                    'maxLength'=>100,
                    'validator' => 'alphastrings',
                    'formatting' => array(
                        'trim',
                        'upperfirstletters'
                        )
                    ),
                'city_out' => array(
                    'type' => 'inputText',
                    'label'=> 'Место вылета (Страна, город, регион)',
                    'required' => true,
                    'minLength' => 3,
                    'maxLength'=>100,
                    'validator' => 'alphastrings',
                    'formatting' => array(
                        'trim',
                        'upperfirstletters'
                        )
                    ),
                'city_in' => array(
                    'type' => 'inputText',
                    'label'=> 'Куда хотите съездить',
                    'required' => true,
                    'minLength' => 3,
                    'maxLength'=>100,
                    'validator' => 'alphastrings',
                    'formatting' => array(
                        'trim',
                        'upperfirstletters'
                        )
                    ),
                'night_count' => array(
                    'type' => 'inputText',
                    'label'=> 'Кол-во ночей',
                    'maxLength'=>3,
                    'required' => false,
                    'validator' => 'num',
                    'formatting' => array(
                        'trim'
                        )
                    ),
                'men_count' => array(
                    'type' => 'inputText',
                    'label'=> 'Кол-во взрослых человек',
                    'maxLength'=>3,
                    'validator' => 'num',
                    'formatting' => array(
                        'trim'
                        )
                    ),
                'air_class' => array(
                    'type' => 'radio',
                    'label'=> 'Класс перелёта',
                    'items'=> array(
                        '0' => 'эконом',
                        '1' => 'бизнес'
                    ),
                    'selected' => '0',
                    'position' => 'h'
                    ),
                'date_out' => array(
                    'type' => 'inputText',
                    'label'=> 'Дата начала тура',
                    'maxLength'=>64,
                    'validator' => 'custom',
                    'formatting' => array(
                        'trim'
                        )
                    ),
                'category' => array(
                    'type' => 'list',
                    'label'=> 'Категория номера',
                    'items' => array(
                        '1' => '1 звезда',
                        '2' => '2 звезды',
                        '3' => '3 звезды',
                        '4' => '4 звезда',
                        '5' => '5 звезд',
                        )
                    ),
                'type' => array(
                    'type' => 'list',
                    'label'=> 'Тип номера',
                    'items' => array(
                        '1' => 'одноместный',
                        '2' => '2х-местный, 2 кровати',
                        '3' => '2х-местный, 1 кровать',
                        '4' => 'многоместный'
                        )
                    ),
                'insurance' => array(
                    'type' => 'checkbox',
                    'label'=> 'Страховка',
                    'title'=> 'Медицина и другое',
                    'selected' => true
                    ),
                'wishes' => array(
                    'type' => 'inputText',
                    'label'=> 'Дополнительные пожелания',
                    'validator' => 'custom',
                    'maxLength' => 1000
                    ),
                'tel' => array(
                    'type' => 'inputText',
                    'label'=> 'Контактный телефон (с кодом)',
                    'validator' => 'phone',
                    'maxLength' => 100
                    ),
                'email' => array(
                    'type' => 'inputText',
                    'label'=> 'E-Mail',
                    'required' => true,
                    'maxLength'=>128,
                    'validator' => 'email'
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
