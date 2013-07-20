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
       /*
        if ($_FILES['files']['type'][0] != 'text/xml')
        {
            $result = array('error', 'Unsupported file type ('.$_FILES['files']['name'][0].')');
            $this->view->json($result);
            $this->view->dispatch();
            exit;
        }
         * 
         */
        if ($_FILES['files']['size'][0] > 4000000)
        {
            ComResponse::JSON(array('message', array('Error'=>'File size more 4 MB ('.$_FILES['files']['size'][0].' byte in '.$_FILES['files']['name'][0].')')));
            exit;
        }
        
        move_uploaded_file($_FILES['files']['tmp_name'][0], PATH.'data/upload/'.$_FILES['files']['name'][0]);
        ComResponse::JSON(array('success', $_FILES['files']['name'][0]));
    }
    
    public function updatetitleAction()
    {
        $params = ComRoute::getParams();
        switch ($params[0])
        {
            case 'big'  : $table = 'index_frame';
            case 'small': $table = 'index_baner';
            case 'pages': $table = 'pages';
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
       $params = ComRoute::getParams();
       $page_id = intval($params[0]);
       $status = ($params[1]==0)? false:true;
       ComDBCommand::update('pages', array('active' => $status), array('id' => $page_id));
       ComResponse::JSON(array('refresh'));
   }
   
   public function deleteofferAction()
   {
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
       $params = ComRoute::getParams();
       $order_id = intval($params[0]);
       ComDBCommand::delete('orders', array('id'=>$order_id));
       ComResponse::JSON(array('refresh'));
   }
}

?>
