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
            sideBar::render($records->lt_sb, $records->ld_sb, $records->r_sb);
            ComHTML::setVar('BODY', stripcslashes($records->content));
            ComHTML::dispatch();
        }
    }
    
}

?>