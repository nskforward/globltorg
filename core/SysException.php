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
        ComResponse::setCode(500);
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
        if (ComRequest::isAccept('application/json'))
        {
            ComResponse::JSON(array('message', array('Internal Server Error' => 'Please continue your work after a few minutes')));
            return;
        }
        echo '<h2>Internal Server Error</h2>Please continue your work after a few minutes';
    }

    protected function showDebugInfo()
    {
        if (ComRequest::isAccept('application/json'))
        {
            ComResponse::JSON(array('message', array('Unexpected Error' => '<div class="scroll"><b>'.$this->getMessage().'</b><br>'.$this->file.' : '.$this->getLine().'<pre>'.$this->getTraceAsString().'</pre></div>')));
            return;
        }
        echo '<h2>Unexpected Error</h2><b>'.$this->getMessage().'</b><br>'.$this->file.' : '.$this->getLine().'<pre>'.$this->getTraceAsString().'</pre>';
    }
}

?>
