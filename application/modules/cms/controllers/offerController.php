<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offerController
 *
 * @author ishibkikh
 */
class offerController
{
    public function _autoload($key)
    {
        $id = intval($key);
        $rec = ComDBCommand::getRow('pages', array('id'=>$id));
        if (!$rec)
        {
            WebApp::system404();
        }
        
        ComHTML::load('cms');
        ComHTML::title($rec->title);
        $form = new ComForm('offer');
        $form->addElement('title', array('value' => $rec->title));
        $form->addElement('state', array('selected' => $rec->active));
        $form->addElement('url', array('value' => $rec->url));
        $form->addElement('content', array('value' => $rec->content));
        $form->editAction('/cms/offer/submit');
        $form->editSubmitTitle('Изменить');
        $form->addElement('id', array('type'=>'hidden', 'value'=>$id));
        $form->compile();
        ComHTML::setJSCode($form->getJavaScript());
        ComHTML::append($form->getHtml());
        ComHTML::dispatch();
    }
    
    public function submitAction()
    {
        $id = intval($_POST['id']);
        $inputs = ComValidator::isValidate($_POST, 'offer');
        if (!$inputs)
        {
            ComResponse::JSON(array('error', $form->getErrors()));
            exit;
        }
        
        $values = array();
        $values['title'] = $inputs['title'];
        $values['url'] = $inputs['url'];
        $values['active'] = intval($inputs['state']);
        $values['offer'] = 1;
        $values['content'] = $inputs['content'];
        
        ComDBCommand::update('pages', $values, array('id' => $id));
        ComResponse::JSON(array('redirect', '/cms/offers'));
    }
}

?>
