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
        sideBar::render('order_1.jpg', 'order_2.jpg', 'order_3.jpg');
        ComHTML::dispatch();
    }
}

?>
