<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of debugController
 *
 * @author ishibkikh
 */
class debugController extends ComRoutController
{
    public function indexAction()
    {
       echo 'debug index<br>';
    }
    
    public function _init()
    {
        echo 'debug init<br>';
    }
    
    public function _end()
    {
        echo 'debug end<br>';
    }
}

?>
