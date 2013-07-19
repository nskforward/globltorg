<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of error404Controller
 *
 * @author ishibkikh
 */

class error404Controller
{
    public function indexAction()
    {
        ComResponse::setCode(404);
        ComHTML::load('general');
        ComHTML::load('system/error404');
        ComHTML::title('Page not found');
        ComHTML::setVar('URL', $_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
        ComHTML::dispatch();
    }
}

?>
