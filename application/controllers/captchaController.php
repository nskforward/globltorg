<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Captcha generation | 1.0.0  * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
class captchaController
{
   public function indexAction()
   {
       ComWebUser::runAsGuestIfNotRunning();
       require_once(PATH.'components/ui/kcaptcha/kcaptcha.php');
       $captcha = new KCAPTCHA();
       ComSession::set('captcha_key', ComSecurity::hash256($captcha->getKeyString()));
   }
}
?>
