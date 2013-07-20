<?php

/* * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Home page | 1.0.0 * 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
class orderController
{
    public function indexAction()
    { 
        ComHTML::load('general');
        ComHTML::title('Заказ путешествия');
        ComHTML::h1('Персональный подбор туров');
        ComHTML::setForm('order');
        ComHTML::setVar('LEFT_SIDEBAR', '<div id="sidebar-1" class="sidebarN" ><div class="frame-img-1"><div><img style="visibility: hidden;" onload="resizing_pictures(this,349,222,\'cnow\');" src="/img/order_1.jpg" alt=""></div></div><div class="frame-img-2"><div><img style="visibility: hidden;" src="/img/order_2.jpg" onload="resizing_pictures(this,343,221,\'cnow\');" alt=""></div></div></div>');
        ComHTML::setVar('RIGHT_SIDEBAR', '<div id="sidebar-2" class="sidebarN"><div class="frame-img-3"><div><img style="visibility: hidden;" onload="resizing_pictures(this,348,310,\'cnow\');" src="/img/order_3.jpg" alt="" /></div></div></div>');
        ComHTML::dispatch();
    }
}

?>
