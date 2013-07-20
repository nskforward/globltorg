<?php

/* * * * * * * * * * * * * * * * * * * * * * * * 
 * DreamQ Modul Controller | World page | 1.0.0* 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
 
 If ($this->params[1] == null)
 {
    $this->setContentType('html');
    $this->setTitle('Спецпредложения');
    $this->loadMainTemplate(1);
    $db = new dbClass('pages');
    $items = $db->getByValue('offer', 1, 50, 'order`, `id', true);
        If ($db->count()==0)
        {
            $this->setVar('BODY', '<p>В настоящее время нет специальных предложений</p>');
        }
        else
        {
            $baners = '<div class="offer_baners">';
            for ($i=0;$i<$db->count();$i++)
            {
                $baners .= '<div class="offer_row"><a href="/offers/'.$items[$i]->url.'" title="'.$items[$i]->title.'">
                <img width="325" height="212" alt="'.$items[$i]->title.'" src="/img/'.$items[$i]->lt_sb.'" onload="resizing_pictures(this,325,200,\'cnow\');" ></a>
                <h2>'.$items[$i]->title.'</h2></div>';
            }
            $baners .= '</div>';
            $this->setVar('BODY', $baners);
        }
     $this->setResponse();   
 }
 else
 {
    $db = new dbClass('pages');
    $items = $db->getByValue('url', $this->params[1]);
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
 }
?>
