<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class callbackController
{
    public function indexAction()
    {
        ComHTML::load('general');
        ComHTML::load('callback');
        ComHTML::title('Заказать звонок');
        sideBar::render(null, null, 'zvonok.jpg');
        ComHTML::dispatch();
    } 
}
?>
