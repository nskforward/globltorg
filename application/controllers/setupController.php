<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Data Base Setup | 1.0.0 * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
$this->setContentType('text');
$db = new dbClass(NULL);
$result = $db->importDamp('user13874_globltorg');
If ($result == 1)
{
    echo 'success';
}
?>
