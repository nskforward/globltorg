<?php

/* * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Home page | 1.0.0 * 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
 $this->setContentType('html');
 $this->setTitle(translate('tourist_services_title'));
 $this->content = $this->template->load('index');
 $db = new dbClass('index_frame');
 $item = $db->getByValue('active', 1, 50, 'id', true);
 $count = $db->count();
 $frames = '';
 If ($count == 1)
 {
     $frames = '<a href="/'.$item->url.'"><img class="indeximage" id="image_0" src="/img/'.$item->src.'" alt="'.$item->title.'" onload="resizing_pictures(this,937,588,\'cnow\');"></a>';
 }
 elseIf($count > 1)
 {
     For ($i=0;$i<$count;$i++)
     {
         $frames .= '<a href="/'.$item[$i]->url.'"><img class="indeximage" id="image_'.$i.'" src="/img/'.$item[$i]->src.'" alt="'.$item[$i]->title.'" onload="resizing_pictures(this,937,588,\'cnow\');"></a>';
     }
 }
 $this->setVar('FRAMES', $frames);
 
 $db = new dbClass('index_baner');
 $item = $db->getByValue('active', 1, 50);
 $count = $db->count();
 $frames = '';
 If ($count == 1)
 {
     $frames = '<a id="gallery_1" class="gallery_item item_301" rel="gallery" title="'.$item->title.'" href="/'.$item->url.'"><img onload="resizing_pictures(this,325,200,\'cnow\');" src="/img/'.$item->src.'" alt="'.$item->title.'"></a>';
 }
 elseIf($count > 1)
 {
     For ($i=0;$i<$count;$i++)
     {
         $frames .= '<a id="gallery_'.$i.'" class="gallery_item item_301" rel="gallery" title="'.$item[$i]->title.'" href="/'.$item[$i]->url.'"><img onload="resizing_pictures(this,325,200,\'cnow\');" src="/img/'.$item[$i]->src.'" alt="'.$item[$i]->title.'"></a>';
     }
 }
 $this->setVar('BANERS', $frames);
 
 $this->setResponse();
?>
