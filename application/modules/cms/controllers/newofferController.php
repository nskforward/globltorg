<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newofferController
 *
 * @author ishibkikh
 */
class newofferController
{
    public function indexAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Спецпредложение');
        ComHTML::h1('Новое спецпредложение');
        $form = new ComForm('offer');
        $form->compile();
        ComHTML::setJSCode($form->getJavaScript());
        ComHTML::append($form->getHtml());
        ComHTML::dispatch();
    }
    
    public function submitAction()
    {
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
        
        ComDBCommand::insert('pages', $values);
        ComResponse::JSON(array('redirect', '/cms/offers'));
    }
}

?>
