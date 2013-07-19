<?php

function getFormBanner()
{
    return array(
            'name' => 'banner',
            'class' => 'form',
            'action' => 'submit',
            'submit_title' => 'Создать',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'title' => array(
                    'type' => 'text',
                    'label'=> 'Название баннера',
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
                'link' => array(
                  'type' => 'list',
                  'label'=> 'Ссылается на',
                  'required' => true,
                  'validator' => 'num'
                ),
                'img' => array(
                    'type' => 'file',
                    'label'=> 'Картинка',
                    'url' => 'cms/processing/upload',
                    'maxSize' => '4000000'
                    )
            )
        );
}


?>
