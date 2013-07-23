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
    final public function _inheritance()
    {
        ComRoute::leftUrl();
        $params = ComRoute::getParams();
        if ((ComRoute::getController() == null)or(ComRoute::getController() == 'index'))
        {
            if (method_exists($this, 'indexAction'))
            {
                $this->indexAction();
            }
            else
            {
                WebApp::system404();
            }
        }
        else
        {
            WebApp::getInstance(ComRoute::getController(), ComRoute::getAction(), ComRoute::getModule());
        }
        return false;
    }
}

?>
