<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomApplication
 *
 * @author ishibkikh
 */
require_once 'core/SysApplication.php';

class WebApp extends SysApplication
{
    public function __construct()
    {
        parent::__construct(str_replace("\\","/",dirname( __FILE__ ))."/");
        ComConfigINI::init('config.ini');
        WebApp::init(ComConfigINI::get('debug'), ComConfigINI::get('timezone'), ComConfigINI::get('gzip'), 'rus');
        WebApp::registryDefaultRoute('index', 'index');
        ComRoute::init();
        ComSession::init();
        ComWebUser::init();
        WebApp::registryError404('error404');
        WebApp::getInstance(ComRoute::getController(), ComRoute::getAction(), ComRoute::getModule());
        exit;
    }
}

?>
