<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indexController
 *
 * @author ishibkikh
 */
class indexController extends ComPController
{
    public function indexAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Управление сайтом');
        ComHTML::h1('Welcome');
        $names = explode(' ', ComWebUser::getName());
        ComHTML::p('Приветсвуем вас, <b>'.$names[0].'</b>');
        ComHTML::p('Для редактирования данных, откройте соответствующий раздел в верхнем меню');
        ComHTML::br();
        ComHTML::hr();
        ComHTML::p('DreamQ Framwork 0.03 | updated 23.07.2013');
        ComHTML::dispatch();
    }
}

?>
