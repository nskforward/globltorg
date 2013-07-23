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
        
        if (ComRequest::isAccept('application/json'))
        {
            ComResponse::JSON(array('message', array('Страница не найдена' => $_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'])));
            return;
        }
        ComHTML::load('general');
        sideBar::render('error_1.png', null, 'error_2.png');
        ComHTML::load('system/error404');
        ComHTML::title('Page not found');
        ComHTML::setVar('URL', $_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
        ComHTML::dispatch();
    }
}

?>
