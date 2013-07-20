<?php

/* * * * * * * * * * * * * * * * * * * * * * * * 
 * DreamQ Modul Controller | World page | 1.0.0* 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
class offersController
{
    
    public function indexAction()
    {
        ComHTML::load('general');
        ComHTML::title('Спецпредложения');
        $records = ComDBConnection::query('select * from pages where offer = 1 and active = 1 order by id desc;');
        $baners = '<div class="offer_baners">';
        foreach ($records as $rec)
        {
            $img = ($rec->lt_sb)?$rec->lt_sb:'default.jpg';
            $baners .= '<div class="offer_row"><a href="/offers/'.$rec->url.'" title="'.$rec->title.'">
                <img width="325" height="212" alt="'.$rec->title.'" src="/img/'.$img.'" onload="resizing_pictures(this,325,200,\'cnow\');" ></a>
                <h2>'.$rec->title.'</h2></div>';
        }
        $baners .= '</div>';
        ComHTML::setVar('BODY', $baners);
        ComHTML::dispatch();
    }
    
    public function _autoload($string)
    {
        $records = ComDBCommand::getRow('pages', array('url'=>$string));
        if (!$records)
        {
            WebApp::system404();
        }
        else
        {
            ComHTML::load('general');
            ComHTML::title($records->title);
            if ($records->ld_sb !== null)
            {
                ComHTML::setVar('LEFT_SIDEBAR', '<div id="sidebar-1" class="sidebarN" ><div class="frame-img-1"><div><img style="visibility: hidden;" onload="resizing_pictures(this,349,222,\'cnow\');" src="/img/'.$records->lt_sb.'" alt=""></div></div><div class="frame-img-2"><div><img style="visibility: hidden;" src="/img/'.$records->ld_sb.'" onload="resizing_pictures(this,343,221,\'cnow\');" alt=""></div></div></div>');
            }
            elseIf($records->lt_sb !== null)
            {
                ComHTML::setVar('LEFT_SIDEBAR', '<div id="sidebar-1" class="sidebarN" ><div class="frame-img-1"><div><img style="visibility: hidden;" onload="resizing_pictures(this,349,222,\'cnow\');" src="/img/'.$records->lt_sb.'" alt=""></div></div></div>');
            }
            if ($records->r_sb !== null)
            {
                ComHTML::setVar('RIGHT_SIDEBAR', '<div id="sidebar-2" class="sidebarN"><div class="frame-img-3"><div><img style="visibility: hidden;" onload="resizing_pictures(this,348,310,\'cnow\');" src="/img/'.$records->r_sb.'" alt="" /></div></div></div>');
             }
            ComHTML::setVar('BODY', stripcslashes($records->content));
            ComHTML::dispatch();
        }
    }
    
}

?>