<?php

function getFormUpload()
{
    return array(
            'name' => 'upload',
            'class' => 'form',
            'action' => '/cms/imagechange/submit',
            'submit_title' => 'Сохранить',
            'method' => 'post',
            'enctype' => 'multipart/form-data',
            'autocomplete' => false,
            'elements' => array(
                'file' => array(
                    'type' => 'file',
                    'url' => 'cms/processing/upload',
                    'maxSize' => '4000000',
                    'required' => true
                    )
            )
        );
}


?>
