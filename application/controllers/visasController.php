<?php

/* * * * * * * * * * * * * * * * * * * * * * * * 
 * DreamQ Modul Controller | page | 1.0.0* 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
class visasController
{
    public function indexAction()
    {
        menuPage::render(ComRoute::getController());
    }
}

?>
