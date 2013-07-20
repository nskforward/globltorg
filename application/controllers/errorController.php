<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Open home page | 1.0.0  * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
$this->setContentType('html');
$this->loadMainTemplate();
$this->setTitle('Страница не найдена');
$this->setLSBar('error_1.png', null);
$this->setRSBar('error_2.png');
$this->setCode("404");
$this->setVar('URL', $_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
$this->setResponse();
?>
