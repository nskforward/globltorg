<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CError
 *
 * @author ishibkikh
 */
class SysException extends Exception
{
    public function __construct($message)
    {
        $this->message = $message;
        if (DEBUG_MODE)
        {
            $this->showDebugInfo();
        }
        else
        {
            error_log(" - ERROR - ".$this->getMessage().' ['.$this->getFile().':'.$this->getLine().']');
            $this->showPrivateInfo();
        }
    }

    protected function showPrivateInfo()
    {
        echo '<h2>Internal Server Error</h2>Please continue your work after a few minutes';
    }

    protected function showDebugInfo()
    {
        echo '<h2>Unexpected Error</h2><b>'.$this->getMessage().'</b><br>'.$this->file.' : '.$this->getLine().'<pre>'.$this->getTraceAsString().'</pre>';
    }
}

?>
