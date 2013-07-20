<?php

/* * * * * * * * * * * * * * * * * * * * * * * * 
 * DreamQ Modul Controller | page | 1.0.0* 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
class servicesController
{
    public function indexAction()
    {
        menuPage::render(ComRoute::getController());
    }
}

?>
