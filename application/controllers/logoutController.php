<?php

/* * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Log Out | 1.0.0 * 
 * * * * * * * * * * * * * * * * * * * * * * *
 */
$this->sess->close();
$this->redirect('/');

?>
