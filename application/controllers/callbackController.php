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
        ComHTML::setVar('RIGHT_SIDEBAR', '<div id="sidebar-2" class="sidebarN"><div class="frame-img-3"><div><img style="visibility: hidden;" onload="resizing_pictures(this,348,310,\'cnow\');" src="/img/zvonok.jpg" alt="" /></div></div></div>');
        ComHTML::dispatch();
    } 
}
?>
