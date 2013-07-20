<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author ishibkikh
 */
interface IConfig
{
    public static function init($filename);
    public static function get($property);
}

?>
