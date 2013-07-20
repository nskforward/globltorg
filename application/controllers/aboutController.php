<?php

/* * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Home page | 1.0.0 * 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
class aboutController
{
    public function indexAction()
    {
        $records = ComDBCommand::getRow('pages', array('url' => ComRoute::getController()));
        if (!$records)
        {
            WebApp::system404();
        }
        
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

?>
