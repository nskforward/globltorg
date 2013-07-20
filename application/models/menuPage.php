<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menuPage
 *
 * @author ivan
 */
class menuPage
{
    static public function render($controller)
    {
        $records = ComDBCommand::getRow('pages', array('url' => $controller));
        if (!$records)
        {
            WebApp::system404();
        }
        
        ComHTML::load('general');
        ComHTML::title($records->title);
        sideBar::render($records->lt_sb, $records->ld_sb, $records->r_sb);
        ComHTML::setVar('BODY', stripcslashes($records->content));
        ComHTML::dispatch();
    }
}

?>
