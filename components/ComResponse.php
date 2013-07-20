<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComResponse
 *
 * @author ishibkikh
 */
class ComResponse
{
    static public function setCode($name)
    { 
        switch ($name)
        {
            case "400": $message = '400 Bad Request'; break;
            case "404": $message = '404 Not Found'; break;
            case "500": $message = '500 Internal Server Error'; break;
            default:    $message = '200 OK';
        }
        header($_SERVER['SERVER_PROTOCOL'].' '.$message);
    }
    
    static public function redirect($url)
    { 
        header("Location: ".$url);
    }
    
    static public function setHeader($name, $value)
    {
        header($name.": ".$value);
    }
    
    static public function setContentType($type, $charset='utf-8')
    { 
        switch ($type)
        {
            case "html": header('Content-Type: text/html;charset='.$charset); break;
            case "text": header('Content-Type: text/plain;charset='.$charset); break;
            case "xhtml": header('Content-Type: application/xhtml+xml;charset='.$charset); break;
            case "xml": header('Content-Type: text/xml;charset='.$charset); break;
            case "json": header('Content-Type: application/json;charset='.$charset); break;
            case "jpeg": header('Content-Type: image/jpeg'); break;
            default: header('Content-Type: text/html;charset='.$charset); break;
        }
    }
    
    static public function setBrowserNoCache()
    { 
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    
    static public function JSON($array)
    {
        self::setContentType('json');
        echo json_encode($array);
    }
    
    static public function HTML($html)
    {
        self::setContentType('html');
        echo $html;
    }
}

?>
