<?php
/* * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Debugger | 1.0.0  * 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
$this->setContentType('text');

require_once(PATH."emailClass.php");
$m= new Mail;
$m->From('qweqwe@qewqw.qw');
$m->To($this->config->support_email);
$m->Subject('GloblTorg | PING');
$m->Body('Поступил заказ №. Просмотреть информацию вы можете в разделе cms - "Заявки"');
$m->Priority(3);
//$m->smtp_on("smtp.asd.com", "login", "password");
If ($m->Send())
{
    echo 'Отправлено - '.$this->config->support_email;
}
else
{
    echo 'Не отправлено - '.$this->config->support_email;
}

?>