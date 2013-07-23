<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComPrivateController
 *
 * @author ishibkikh
 */
abstract class ComPController
{
    public function _inheritance()
    {
        if (!ComWebUser::isPrivateAccess())
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}

?>
