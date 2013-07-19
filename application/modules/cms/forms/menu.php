<?php

function getFormMenu()
{
    return array(
            'name' => 'menu',
            'class' => 'form',
            'action' => '/cms/menu/submit',
            'submit_title' => 'Изменить',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'content' => array(
                    'type' => 'textarea',
                    'label'=> 'Контент',
                    'minLength' => 4,
                    'required' => true,
                    'maxLength'=>5000
                    )
            )
        );
}


?>
