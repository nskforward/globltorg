<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SysErrorHandler
 *
 * @author ishibkikh
 */
class SysErrorHandler
{
    static public function init()
    {
        set_exception_handler('SysErrorHandler::exception_handler');
	set_error_handler('SysErrorHandler::error_handler');
	register_shutdown_function('SysErrorHandler::shutdown_handler');
    }

    static public function exception_handler($exception)
    {
        restore_error_handler();
        restore_exception_handler();
        if(!$exception instanceof SysException)
        new SysException($exception->getMessage());
    }
 
    static public function error_handler($errno, $errstr, $errfile, $errline)
    {
        if ($errno < 8)
             new SysException($errstr);
    }
 
    static public function shutdown_handler()
    {
        $error = error_get_last();
        if ($error['type'] == 1)
        {  
            new SysException($error['message']);
        }
    }
}

?>
