<?php

function getFormLinks()
{
    return array(
            'name' => 'links',
            'class' => 'form',
            'action' => '/cms/submit/links',
            'submit_title' => 'Изменить',
            'method' => 'post',
            'autocomplete' => false,
            'elements' => array(
                'link'=> array(
                    'type' => 'list',
                    'label' => 'Ссылка',
                    'required' => true
                )
            )
        );
}


?>
