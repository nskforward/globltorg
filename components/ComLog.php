<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logClass
 *
 * @author ivan
 */
class ComLog
{
    static public function debug($text)
    {
        if (($text !== NULL)and(ComConfigINI::get('debug')==1))
        {
            $file = PATH.'data/logs/debug.log';
            file_put_contents($file, ComDateTime::getNow().' - '.$text."\n", FILE_APPEND);
        }
    }
    
    static public function sql($text)
    {
        if (($text !== NULL)and(DEBUGGING===true))
        {
            $file = PATH.'data/logs/sql.log';
            file_put_contents($file, ComDateTime::getNow().' - '.$text."\n", FILE_APPEND);
        }
    }
    
    static public function error($text)
    {
        if ($text == NULL) $text = 'null';
        {
            $file = PATH.'data/logs/error.log';
            file_put_contents($file, ComDateTime::getNow().' - ERROR - '.$text."\n", FILE_APPEND);
        }
    }
}

?>
