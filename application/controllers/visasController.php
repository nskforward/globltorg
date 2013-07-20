<?php

/* * * * * * * * * * * * * * * * * * * * * * * * 
 * DreamQ Modul Controller | page | 1.0.0* 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
 $db = new dbClass('pages');
 $items = $db->getByValue('url', $this->page);
    If ($db->count()==0)
    {
        $this->SetNotFound();
    }
    else
    {
        $this->setContentType('html');
        $this->setTitle($items->title);
        $this->loadMainTemplate(1);
        $this->setLSBar($items->lt_sb, $items->ld_sb);
        $this->setRSBar($items->r_sb);
        $this->setVar('BODY', stripcslashes($items->content));
        $this->setResponse();
    }
?>
