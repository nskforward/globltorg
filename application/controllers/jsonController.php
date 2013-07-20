<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | JSON resources | 1.0.0  * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
$this->setContentType('json');
$json = array('type'=> 'error', 'value' => 'no content');

switch ($this->params[1])
 {
    case 'm_page':
    $this->protectAccess(); 
    $db = new dbClass('pages');
    $page = $db->getById(intval($this->params[2]));
    $json = array(
         'type'     => 'success',
         'value'    => array(
            'title'    => $page->title,
            'url'      => $page->url,
            'content'  => stripcslashes($page->content),
            'lt_sb'    => $page->lt_sb,
            'ld_sb'    => $page->ld_sb,
            'r_sb'    => $page->r_sb
         )
     );
    break;

 
case 'm_continent':
    $this->protectAccess(); 
    $db = new dbClass('continents');
    $page = $db->getById(intval($this->params[2]));
    $json = array(
         'type'     => 'success',
         'value'    => array(
         'title'    => $page->title,
         'url'      => $page->url,
         'content'  => stripcslashes($page->content),
         'lt_sb'    => $page->lt_sb,
         'ld_sb'    => $page->ld_sb,
          'r_sb'    => $page->r_sb
         )
     );
    break;


case 'm_country':
    $this->protectAccess(); 
    $db = new dbClass('places_tour');
    $page = $db->getById(intval($this->params[2]));
    $json = array(
         'type'     => 'success',
         'value'    => array(
         'title'    => $page->title,
         'url'      => $page->url,
         'content'  => stripcslashes($page->content) ,
         'des'      => $page->des,
         'des_img'  => $page->des_img,
         'lt_sb'    => $page->lt_sb,
         'ld_sb'    => $page->ld_sb,
         'r_sb'     => $page->r_sb
         )
     );
    break;



 }
 $this->setResponse(json_encode($json), 0);
?>
