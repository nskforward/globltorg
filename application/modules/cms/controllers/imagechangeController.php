<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of imagechangeController
 *
 * @author ishibkikh
 */
class imagechangeController extends ComPController
{
    public function viewAction()
    {
        ComHTML::load('cms');
        $params = ComRoute::getParams();
        if (!ComValidator::check($params[0], 'anum'))
        {
            ComHTML::p('Неверный формат HTTP-запроса');
            ComHTML::dispatch();
            exit;
        }
        switch ($params[0])
        {
            case 'big'  : $table = 'index_frame'; break;
            case 'small': $table = 'index_baner'; break;
            case 'pages': $table = 'pages'; break;
        }
        $field = $params[1];
        $id = intval($params[2]);
        
        ComHTML::title('Редактирование изображения');
        $rec = ComDBCommand::getRow($table, array('id' => $id));
        if (!$rec)
        {
            ComHTML::p('Баннер не найден');
            ComHTML::dispatch();
            exit;
        }
        
        ComHTML::h2('Старое изображение');
        $img = $rec->{$field};
        if ($img)
        {
            ComHTML::append('<img height="300" width="400" src="/img/'.$rec->{$field}.'">');
        }
        else
        {
            ComHTML::p('Отсутствует');
        }
        ComHTML::h2('Новое изображение');
        $form = new ComForm('upload');
        $form->addElement('table', array('type'=>'inputHidden', 'value'=>$params[0]));
        $form->addElement('field', array('type'=>'inputHidden', 'value'=>$field));
        $form->addElement('id', array('type'=>'inputHidden', 'value'=>$id));
        $form->compile();
        ComHTML::append('<script type="text/javascript">'.$form->getJavaScript().'</script>'.$form->getHtml());
        ComHTML::dispatch();
    }
    
    
    public function submitAction()
    {
        if (!ComWebUser::checkAccess('images', 'update'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
        $id = intval($_POST['id']);
    
        switch ($_POST['table'])
        {
            case 'big'  : $table = 'index_frame'; break;
            case 'small': $table = 'index_baner'; break;
            case 'pages': $table = 'pages'; break;
        }
        
        if (!ComValidator::check($_POST['field'], 'anum'))
        {
            ComResponse::JSON(array('message', array('error'=>'Неверный формат HTTP-запроса')));
            exit;
        }
        $field = $_POST['field'];
        $rec = ComDBCommand::getRow($table, array('id' => $id));
        if (!$rec)
        {
            ComResponse::JSON(array('message', array('error'=>'Неверный формат HTTP-запроса')));
            exit;
        }
        
        $array = (array)$_POST['uploads'];
        $uploaded_img = PATH.'data/upload/'.$array[0];
        $path_parts = pathinfo($uploaded_img);
        $ext = $path_parts['extension'];
        $timestamp = time();
        $new_name = 'img_'.$timestamp.'.'.$ext;
        $new_img = PATH.'public/img/'.$new_name;
        if ($rec->{$field})
        {
            $old_img = PATH.'public/img/'.$rec->{$field};
            if (file_exists($old_img))
            {
                unlink($old_img);
            }
        }
        rename($uploaded_img, $new_img);
        ComDBCommand::update($table, array($field => $new_name), array('id' => $id));
        if ($field=='src')
        {
            ComResponse::JSON(array('redirect', '/cms/banners'));
        }
        else
        {
            if ($rec->offer == 1)
            {
                ComResponse::JSON(array('redirect', '/cms/offers'));
            }
            else
            {
                ComResponse::JSON(array('redirect', '/cms/menu'));
            }
        }
    }
}

?>
