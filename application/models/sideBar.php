<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sideBar
 *
 * @author ivan
 */
class sideBar
{
    static public function render($lefttop, $leftbottom, $right)
    {
        if (($leftbottom !== null)and($lefttop !== null))
        {
            ComHTML::setVar('LEFT_SIDEBAR', '<div id="sidebar-1" class="sidebarN" ><div class="frame-img-1"><div><img style="visibility: hidden;" onload="resizing_pictures(this,349,222,\'cnow\');" src="/img/'.$lefttop.'" alt=""></div></div><div class="frame-img-2"><div><img style="visibility: hidden;" src="/img/'.$leftbottom.'" onload="resizing_pictures(this,343,221,\'cnow\');" alt=""></div></div></div>');
        }    
        elseIf($lefttop !== null)
        {
            ComHTML::setVar('LEFT_SIDEBAR', '<div id="sidebar-1" class="sidebarN" ><div class="frame-img-1"><div><img style="visibility: hidden;" onload="resizing_pictures(this,349,222,\'cnow\');" src="/img/'.$lefttop.'" alt=""></div></div></div>');
        }
        elseIf($leftbottom !== null)
        {
            ComHTML::setVar('LEFT_SIDEBAR', '<div id="sidebar-1" class="sidebarN" ><div class="frame-img-2"><div><img style="visibility: hidden;" onload="resizing_pictures(this,343,221,\'cnow\');" src="/img/'.$leftbottom.'" alt=""></div></div></div>');
        }
        
        if ($right !== null)
        {
            ComHTML::setVar('RIGHT_SIDEBAR', '<div id="sidebar-2" class="sidebarN"><div class="frame-img-3"><div><img style="visibility: hidden;" onload="resizing_pictures(this,348,310,\'cnow\');" src="/img/'.$right.'" alt="" /></div></div></div>');
        }
    }
}

?>
