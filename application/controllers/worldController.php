<?php

/* * * * * * * * * * * * * * * * * * * * * * * * 
 * DreamQ Modul Controller | World page | 1.0.0* 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */

$this->setContentType('html');

// WORLD
 If ($this->params[1] == null)
 {
    $this->setTitle('Страны');
    $this->loadMainTemplate(1);
    $db = new dbClass('continents');
    $items = $db->getAllValues();
    $count = $db->count();
    $body = '<ul class="country">';
    If ($count > 1)
        For ($i=0; $i<$count; $i++)
        {
            $body .= '<li><a href="/world/'.$items[$i]->url.'"><div class="img"><img src="img/'.$items[$i]->des_img.'" alt="'.$items[$i]->title.'" onload="resizing_pictures(this,424,254,\'cnow\');"></div>'.
                     '<span>'.$items[$i]->title.'</span></a><span class="desc"></span></li>
';      }
    elseIf ($count == 1)
        $body = '<li><a href="/world/'.$items->url.'"><div class="img"><img src="img/'.$items->des_img.'" alt="'.$items->title.'" onload="resizing_pictures(this,424,254,\'cnow\');"></div>'.
                '<span>'.$items->title.'</span></a><span class="desc"></span></li>';
    $body .= '</ul>';
    $this->setVar('BODY', $body);
 }
 
 
 
// WORLD/CONTINENT 
 elseIf($this->params[2]==null)
 {
    $db = new dbClass('continents');
    $items = $db->getByValue('url', $this->params[1]);
    If ($db->count()==0)
    {
        $this->SetNotFound();
    }
    else
    {
        $this->setTitle($items->title);
        $this->loadMainTemplate('continent');
        $this->setLSBar($items->lt_sb, $items->ld_sb);
        $this->setRSBar($items->r_sb);
        $this->setVar('BODY_DES', stripcslashes($items->content));
        $this->setVar('NAV', $items->title);
        $this->setVar('ITEMS', GetItemsTourByContinent($items->id, $this->params[1]));
    }
 }
 
 
 
// WORLD/CONTINENT/COUNTRY 
 elseIf($this->params[2] <> null)
 {
    $db = new dbClass('continents');
    $item0 = $db->getByValue('url', $this->params[1]);
    If ($db->count()==0)
    {
        $this->SetNotFound();
    }
          
    $db = new dbClass('places_tour');
    $items = $db->getByValue('url', $this->params[2]);
    If ($db->count()==0)
    {
        $this->SetNotFound();
    }
    else
    {
        $this->loadMainTemplate('country');
        $this->setTitle($items->title);
        $this->setLSBar($items->lt_sb, $items->ld_sb);
        $this->setRSBar($items->r_sb);
        $this->setVar('CNAME', $item0->title);
        $this->setVar('CURL', $item0->url);
        $this->setVar('NAV', $items->title);
        $this->setVar('BODY_DES', stripcslashes($items->content));
    }
 }

 $this->setResponse();
?>
