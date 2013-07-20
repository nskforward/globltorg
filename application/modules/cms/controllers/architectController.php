<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of architectController
 *
 * @author ishibkikh
 */
class architectController extends ComPController
{
    public function getlinksAction()
    {
        $params = ComRoute::getParams();
        $table = ($params[0]=='big')?'index_frame':'index_baner';
        $id = intval($params[1]);
        $rec = ComDBCommand::getRow($table, array('id' => $id));
        if (!$rec)
        {
            ComResponse::JSON(array('message', array('error'=>'Баннер не найден')));
            exit;
        }
        $link_id = $rec->link_id;
        $form = new ComForm('links');
        $form->addElement('link', array('selected' => $link_id ));
        $form->addElement('banner_id', array('type' => 'hidden','value'=> $id));
        $form->addElement('table', array('type' => 'hidden','value'=> $params[0]));
        $records = ComDBCommand::getAll('pages', array('offer' => 1));
        foreach ($records as $record)
        {
            $form->addListItem('link', $record->id, $record->title);
        }
        $form->compile();
        ComResponse::JSON(array('message', array($rec->title => '<script type="text/javascript">'.$form->getJavaScript().'</script>'.$form->getHtml())));
    }
    
    public function editimageAction()
    {
        $params = ComRoute::getParams();
        switch ($params[0])
        {
            case 'big'  : $table = 'index_frame'; break;
            case 'small': $table = 'index_baner'; break;
            case 'pages': $table = 'pages'; break;
        }
        if (!ComValidator::check($params[1], 'anum'))
        {
            ComResponse::JSON(array('message', array('error'=>'Неверный формат HTTP-запроса')));
            exit;
        }
        $field = $params[1];
        $banner_id = intval($params[2]);
        $rec = ComDBCommand::getRow($table, array('id'=>$banner_id));
        if (!$rec)
        {
            ComResponse::JSON(array('message', array('error'=>'Баннер не найден')));
            exit;
        }
        ComHTML::title('Предпросмотр');
        $img = $rec->{$field};
        if ($img)
        {
            ComHTML::append('<img height="500" width="800" src="/img/'.$img.'">');
        }
        else
        {
            ComHTML::p('Отсутствует');
        }
        ComHTML::hr();
        ComHTML::append('<a href="/cms/imagechange/view/'.$params[0].'/'.$field.'/'.$rec->id.'"><button>Изменить</button></a>');
        ComResponse::JSON(ComHTML::packToJSON());
    }
    
    
    public function getorderAction()
    {
        $params = ComRoute::getParams();
        $id = intval($params[0]);
        ComHTML::title('Заявка №'.$id);
        $rec = ComDBCommand::getRow('orders', array('id' => $id));
        ComHTML::append('<table class="table text-left">');
        ComHTML::append('<tr><td>ФИО</td><td><b>'.$rec->client_name.'</b></td></tr>');
        if ($rec->tel != null) ComHTML::append('<tr><td>Телефон</td><td><b>'.$rec->tel.'</b></td></tr>');
        if ($rec->email != null) ComHTML::append('<tr><td>E-mail</td><td><a href="/cms/message/'.$rec->id.'">'.$rec->email.'</a></td></tr>');
        ComHTML::append('<tr><td>Дата вылета</td><td><b>'.$rec->date_out.'</b></td></tr>');
        ComHTML::append('<tr><td>Из</td><td><b>'.$rec->city_out.'</b></td></tr>');
        ComHTML::append('<tr><td>В</td><td><b>'.$rec->city_in.'</b></td></tr>');
        if ($rec->air_class_business != null)
        {
            if ($rec->air_class_business == 1)
            ComHTML::append('<tr><td>Класс перелёта</td><td><b>бизнес</b></td></tr>');
            else
            ComHTML::append('<tr><td>Класс перелёта</td><td><b>эконом</b></td></tr>');
        }
        if ($rec->insurance == 1) 
        {
            ComHTML::append('<tr><td>Страховка</td><td><b>есть</b></td></tr>');
        }
        if ($rec->men_count != null) ComHTML::append('<tr><td>Кол-во человек</td><td><b>'.$rec->men_count.'</b></td></tr>');
        if ($rec->night_count != null) ComHTML::append('<tr><td>Кол-во ночей</td><td><b>'.$rec->night_count.'</b></td></tr>');
        if ($rec->category != null) ComHTML::append('<tr><td>Отель звёзд</td><td><b>'.$rec->category.'</b></td></tr>');
        if ($rec->type != null)
        {
            switch ($rec->type)
            {
                case 1: $category='одноместный'; break;
                case 2: $category='2х местный, 2 кровати'; break;
                case 3: $category='2х местный, 1 кровать'; break;
                case 4: $category='многоместный'; break;
            }
            ComHTML::append('<tr><td>Тип номера</td><td><b>'.$category.'</b></td></tr>');
        }
        if ($rec->wishes != null) ComHTML::append('<tr><td>Пожелания</td><td><b>'.$rec->wishes.'</b></td></tr>');
        ComResponse::JSON(ComHTML::packToJSON());
    }
}

?>
