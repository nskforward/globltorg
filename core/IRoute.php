<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author ishibkikh
 */
interface IRoute
{
    static public function init();
    static public function getController();
    static public function getAction();
    static public function getParams();
}

?>
