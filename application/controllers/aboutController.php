<?php

/* * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Home page | 1.0.0 * 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
class aboutController
{
    public function indexAction()
    {
        menuPage::render(ComRoute::getController());
    }
}

?>
