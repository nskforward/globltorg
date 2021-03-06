<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of processingController
 *
 * @author ishibkikh
 */
class processingController extends ComPController
{
    public function uploadAction()
    {
        if (!ComWebUser::checkAccess('images', 'create'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
        
        $form = new ComForm('upload');
        $params = $form->getElements();
        if (!in_array($_FILES['files']['type'][0], $params['file']['accept']))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'Загружаемый вами файл имеет неподдерживаемый тип "'.$_FILES['files']['type'][0].'"')));
            return;
        }
      
        if ($_FILES['files']['size'][0] > $params['file']['maxSize'])
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'Загружаемый файл превышает лимит для размера файла')));
            return;
        }

        move_uploaded_file($_FILES['files']['tmp_name'][0], PATH.'data/upload/'.$_FILES['files']['name'][0]);
        ComResponse::JSON(array('success', $_FILES['files']['name'][0]));
    }
    
    public function updatetitleAction()
    {
       if (!ComWebUser::checkAccess('offers', 'update'))
       {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
       }
        $params = ComRoute::getParams();
        switch ($params[0])
        {
            case 'big'  : $table = 'index_frame'; break;
            case 'small': $table = 'index_baner'; break;
            case 'pages': $table = 'pages'; break;
        }
        
        $banner_id = intval($params[1]);
        if (!ComValidator::check($_POST['query'], 'alphastrings'))
        {
            ComResponse::JSON(array('message', array('error'=>'Неверный формат HTTP-запроса')));
            exit;
        }
        
        $new_title = $_POST['query'];
        ComDBCommand::update($table, array('title' => $new_title), array('id' => $banner_id));
        ComCacheFile::delete('index'.'index');
        ComResponse::JSON(array('refresh'));
    }
    
    public function activatebannAction()
    {
       if (!ComWebUser::checkAccess('banners', 'update'))
       {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
       }
       $params = ComRoute::getParams();
       $table = ($params[0]=='big')?'index_frame':'index_baner';
       $banner_id = intval($params[1]);
       $status = ($params[2]==0)? false:true;
       ComDBCommand::update($table, array('active' => $status), array('id' => $banner_id));
       ComCacheFile::delete('index'.'index');
       ComResponse::JSON(array('refresh'));
    }
    
   public function deletebannerAction()
   {
       if (!ComWebUser::checkAccess('banners', 'delete'))
       {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
       }
       $params = ComRoute::getParams();
       $table = ($params[0]=='big')?'index_frame':'index_baner';
       $banner_id = intval($params[1]);
       $rec = ComDBCommand::getRow($table, array('id'=>$banner_id));
       if ($rec)
       {
           $img = PATH.'public/img/'.$rec->src;
           unlink($img);
           ComDBCommand::delete($table, array('id'=>$banner_id));
       }
       ComCacheFile::delete('index'.'index');
       ComResponse::JSON(array('refresh'));
   }
   
   public function activatepageAction()
   {
       if (!ComWebUser::checkAccess('offers', 'update'))
       {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
       }
        
       $params = ComRoute::getParams();
       $page_id = intval($params[0]);
       $status = ($params[1]==0)? false:true;
       ComDBCommand::update('pages', array('active' => $status), array('id' => $page_id));
       ComResponse::JSON(array('refresh'));
   }
   
   public function deleteofferAction()
   {
       if (!ComWebUser::checkAccess('offers', 'delete'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
       
       $params = ComRoute::getParams();
       $offer_id = intval($params[0]);
       $records = ComDBCommand::getRow('index_frame', array('link_id' => $offer_id));
       if ($records)
       {
           ComResponse::JSON(array('message', array('Ошибка' => 'На эту страницу ссылается большой баннер. Сперва удалите этот баннер.')));
           exit;
       }
       $records = ComDBCommand::getRow('index_baner', array('link_id' => $offer_id));
       if ($records)
       {
           ComResponse::JSON(array('message', array('Ошибка' => 'На эту страницу ссылается маленький баннер. Сперва удалите этот баннер.')));
           exit;
       }
       $rec = ComDBCommand::getRow('pages', array('id' => $offer_id));
       if ($rec)
       {
           $img = PATH.'public/img/'.$rec->lt_sb;
           if (is_file($img)) unlink($img);
           $img = PATH.'public/img/'.$rec->ld_sb;
           if (is_file($img)) unlink($img);
           $img = PATH.'public/img/'.$rec->r_sb;
           if (is_file($img)) unlink($img);
           
           ComDBCommand::delete('pages', array('id'=>$offer_id));
       }
       ComResponse::JSON(array('refresh'));
   }
   
   public function deleteorderAction()
   {
       if (!ComWebUser::checkAccess('orders', 'delete'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
       
       $params = ComRoute::getParams();
       $order_id = intval($params[0]);
       ComDBCommand::delete('orders', array('id'=>$order_id));
       ComResponse::JSON(array('refresh'));
   }
   
   public function updatecourseAction()
   {
       if (!ComWebUser::checkAccess('courses', 'update'))
        {
            ComResponse::JSON(array('message', array('Ошибка'=>'У вас недостаточно прав для выполнения этого действия')));
            return;
        }
       
       $params = ComRoute::getParams();
       $course_id = intval($params[0]);
       if (!ComValidator::check($_POST['query'], 'decimal'))
       {
            ComResponse::JSON(array('message', array('error'=>'Неверный формат обновляемого значения')));
            exit;
       }
       
       $new_value = $_POST['query'];
       
       if (!$new_value)
       {
           ComResponse::JSON(array('message', array('Ошибка' => ComValidator::getErrorText('decimal'))));
       }
       else
       {
           ComDBCommand::update('course', array('value' => $new_value), array('id' => $course_id));
           ComCacheFile::delete('index'.'index');
           ComResponse::JSON(array('refresh'));
       }
   }
}

?>
