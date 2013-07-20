<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Message page | 1.0.0  * 
 * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
$success = "yes_big.png";
$info    = "warning.png";
$fail    = "error.png";

$this->setContentType('html');
$this->loadMainTemplate(1);
switch ($this->params[1])
{
case "reg":
$this->setTitle('Завершение регистрации');
$this->setVar('ICON', $success);
$this->setVar('COLOR', 'green');
$this->setVar('MESSAGE', 'Регистрация прошла успешно');
break;

case "support":
$this->setTitle('Запрос успешно отправлен');
$this->setVar('ICON', $success);
$this->setVar('COLOR', 'green');
$this->setVar('MESSAGE', 'Ваш запрос успешно принят. В ближайшее время его обработают и сразу же с вами свяжутся.');
break;

default :
$this->setTitle('Error');
$this->setVar('ICON', $fail);
$this->setVar('COLOR', 'red');
$this->setVar('MESSAGE', 'Error');
$this->setCode("500");
break;
}
$this->setResponse();
?>
