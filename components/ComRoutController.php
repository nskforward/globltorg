<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComRoutController
 *
 * @author ishibkikh
 */
abstract class ComRoutController
{
    public function _inheritance()
    {
        $params = ComRoute::getParams();
        if ((ComRoute::getAction() == null)or(ComRoute::getAction() == 'index'))
        {
            $this->indexAction();
        }
        else
        {
            WebApp::getInstance(ComRoute::getAction(), $params[0], ComRoute::getModule());
        }
        return false;
    }
}

?>
