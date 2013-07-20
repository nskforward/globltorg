<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author ishibkikh
 */
interface IWebUser
{
    static public function isAuth();
    static public function getId();
    static public function getName();
    static public function getGroup();
    static public function registry($id, $name, $group, $remember);
    static public function destroy();
}

?>
