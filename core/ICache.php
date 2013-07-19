<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author ishibkikh
 */
interface ICache
{
    static public function get($key);
    static public function set($key, $value, $timelife);
    static public function delete($key);
}

?>
