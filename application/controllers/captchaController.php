<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Captcha generation | 1.0.0  * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
   $this->setContentType('jpeg');
   $this->noCache();
   require_once(PATH.'kcaptcha/kcaptcha.php');
   $captcha = new KCAPTCHA();
   //$_SESSION['keystring'] = md5($captcha->getKeyString());
   $this->sess->set('keystring', md5($captcha->getKeyString()));
?>
