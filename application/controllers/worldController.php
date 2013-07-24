<?php

/* * * * * * * * * * * * * * * * * * * * * * * * 
 * DreamQ Modul Controller | World page | 1.0.0* 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
class worldController
{
    public function indexAction()
    {
        
        ComHTML::load('general');
        ComHTML::title('Страны');
        $records = ComDBCommand::getAll('continents');
        $body = '<ul class="country">';
        foreach ($records as $rec)
        {
            $body .= '<li><a href="/world/'.$rec->url.'"><div class="img"><img src="img/'.$rec->des_img.'" alt="'.$rec->title.'" onload="resizing_pictures(this,424,254,\'cnow\');"></div>'.
                     '<span>'.$rec->title.'</span></a><span class="desc"></span></li>';
        }
        $body .= '</ul>';
        ComHTML::setVar('BODY', $body);
        ComHTML::dispatch();
    }
    
    public function _autoload($string)
    {
        $params = ComRoute::getParams();
        if ($params[0] == null)
        {
            $records = ComDBCommand::getRow('continents', array('url'=>ComRoute::getAction()));
            if (!$records)
            {
                WebApp::system404();
            }
            
            ComHTML::load('general');
            ComHTML::title($records->title);
            ComHTML::load('continent');
            sideBar::render($records->lt_sb, $records->ld_sb, $records->r_sb);
            ComHTML::setVar('BODY_DES', stripcslashes($records->content));
            ComHTML::setVar('NAV', $records->title);
            $items = '<ul class="services">';
                
            $countries = ComDBCommand::getAll('places_tour', array('parent_id' => $records->id));
            foreach ($countries as $rec)
            {
                $items .= '<li><div class="wrap-img"><img src="/img/'.$rec->lt_sb.'" alt="'.$rec->title.'" onload="resizing_pictures(this,425,254,\'cnow\');"><div></div></div><div class="wrap-text">'.
                '<h6>'.$rec->title.'</h6><p>'.$rec->des.'</p><a href="/world/'.ComRoute::getAction().'/'.$rec->url.'">Читать далее</a></div></li>';
            }
            $items .= '</ul>';
            ComHTML::setVar('ITEMS', $items);
        }
        else
        {
            $records = ComDBConnection::query('select p.title as country, c.title as continent, p.lt_sb, p.ld_sb, p.r_sb, p.content from places_tour p, continents c where p.url="'.$params[0].'" and c.id=p.parent_id;');
            if (!$records)
            {
                WebApp::system404();
            }
            
            ComHTML::load('general');
            ComHTML::load('country');
            ComHTML::title($records[0]->country);
            sideBar::render($records[0]->lt_sb, $records[0]->ld_sb, $records[0]->r_sb);
            ComHTML::setVar('CNAME',$records[0]->continent);
            ComHTML::setVar('CURL', ComRoute::getAction());
            ComHTML::setVar('NAV', $records[0]->country);
            ComHTML::setVar('BODY_DES', stripcslashes($records[0]->content));
        }
        ComHTML::dispatch();
    }
}

?>
