<?php

/* * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Home page | 1.0.0 * 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
class contactsController
{
    public function indexAction()
    {
        menuPage::render(ComRoute::getController());
    }
} 

?>
