<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of submitController
 *
 * @author ishibkikh
 */
class submitController extends ComPController
{

    public function linksAction()
    {
        if (!ComWebUser::checkAccess('banners', 'update'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
        $banner_id = intval($_POST['banner_id']);
        $table = ($_POST['table']=='big')?'index_frame':'index_baner';
        $link_id = intval($_POST['link']);
        ComDBCommand::update($table, array('link_id' => $link_id), array('id' => $banner_id));
        ComResponse::JSON(array('redirect', '/cms/banners'));
    }
    
    public function checkuniqAction()
    {
        ComResponse::JSON(array('success'));
    }
}

?>
