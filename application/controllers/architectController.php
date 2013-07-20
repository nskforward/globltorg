<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | JSON resources | 1.0.0  * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

function getTitleActBtn($active)
{
    if ($active == 1)
    {
        return 'Отключить';
    }
    else
    {
        return 'Включить';
    }
}

function convert_air_class($str)
{
    If ($str)
        return 'Бизнес';
    else
        return 'Эконом';
}

function convert_insurance($str)
{
    If ($str)
        return 'Есть';
    else
        return 'Нет';
}

function convert_hotel_type($str)
{
    switch ($str)
    {
        case '1': return 'Одноместный'; break;
        case '2': return 'Двухместный (2 кровати)'; break;
        case '3': return 'Двухместный (1 кровать)'; break;
        case '4': return 'Многоместный'; break;
    }
}

$this->protectAccess(); 
$this->setContentType('json');
$json = array('type'=> 'error', 'value' => 'no content');

require_once(PATH."formClass.php");

switch ($this->params[1])
{
    case 'm_order':
        $obj = new formClass($this->params[1]);
        $db = new dbClass('orders');
        $order = $db->getById(intval($this->params[2]));
        $form = '<h2>Заявка №'.$order->id.'</h2>';
        $form .= $obj->getHTML();
        $form = $this->template->set_var($form, 'DATE_REG',         $order->date_reg);
        $form = $this->template->set_var($form, 'CLIENT_NAME',      $order->client_name);
        $form = $this->template->set_var($form, 'CITY_OUT',         $order->city_out);
        $form = $this->template->set_var($form, 'CITY_IN',          $order->city_in);
        $form = $this->template->set_var($form, 'DATE_OUT',         $order->date_out);
        $form = $this->template->set_var($form, 'NIGHT_COUNT',      $order->night_count);
        $form = $this->template->set_var($form, 'MEN_COUNT',        $order->men_count);
        $form = $this->template->set_var($form, 'CLASS_BUSINESS',   convert_air_class($order->air_class_business));
        $form = $this->template->set_var($form, 'CATEGORY',         $order->category.' (звёзд)');
        $form = $this->template->set_var($form, 'TYPE',             convert_hotel_type($order->type));
        $form = $this->template->set_var($form, 'INSURANCE',        convert_insurance($order->insurance));
        $form = $this->template->set_var($form, 'WISHES',           $order->wishes);
        $form = $this->template->set_var($form, 'EMAIL',            $order->email);
        $form = $this->template->set_var($form, 'TEL',              $order->tel);
        $form .= '<a href="#" onclick="CanRemoveOrder(\''.$order->id.'\');">Удалить заявку</a>';
        $json = array(
         'type'     => 'success',
         'value'    => $form);
    break;

    case 'frames':
        $db = new dbClass('index_frame');
        $item = $db->getAllValues();
        $count = $db->count();
        $frames = '<div class="popup__overlay">
        <div class="popup">
        <a href="#" onclick="PopupHidden();" class="popup__close">X</a>
        <h2>Выберите новое изображение</h2>
        <img id="upload_img" height="200" src="">
        <div class="popup-form__row">
        <p class="red">Внимание! Загружаемое изображение должно быть формата JPEG и иметь размеры 937 x 588</p>
        <form id="upload_form" name="index" enctype="multipart/form-data" action="" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="1500000">
        <input name="userfile" type="file"><input type="submit" value="Заменить"></form>
        </div></div></div>';
        $frames .= '<table class="visible"><tr><th>Название</th><th>Ссылка</th><th>Имя картинки</th><th>Картинка</th><th>Состояние</th></tr>';
        If ($count == 1)
        {
            $frames .= '<tr><td>'.$item->title.'</td><td><a href="/'.$item->url.'">'.$item->url.'</a></td><td><a href="/img/'.$item->src.'" target="_blank">'.$item->src.'</a></td>'.
                    '<td><button onclick="setUploadForm(\''.$item->id.'\', \''.$item->src.'\', \'index_frame\');">Заменить</button></td>'.
                    '<td><button id="state_btn_'.$item->id.'" onclick="setActiveFrame(\''.$item->id.'\', \''.$item->active.'\', \'index_frame\');">'.getTitleActBtn($item[$i]->active).'</button></td></tr>';
        }
        elseIf($count > 0)
        {
            For ($i=0;$i<$count;$i++)
            {
                $frames .= '<tr><td>'.$item[$i]->title.'</td><td><a target="_blank" href="/'.$item[$i]->url.'">'.$item[$i]->url.'</a></td><td><a href="/img/'.$item[$i]->src.'" target="_blank">'.$item[$i]->src.'</a></td>'.
                        '<td><button onclick="setUploadForm(\''.$item[$i]->id.'\', \''.$item[$i]->src.'\', \'index_frame\');">Заменить</button></td>'.
                        '<td><button id="state_btn_'.$item[$i]->id.'" onclick="setActiveFrame(\''.$item[$i]->id.'\', \''.$item[$i]->active.'\', \'index_frame\');">'.getTitleActBtn($item[$i]->active).'</button></td></tr>';
            }
        }
        $frames .= '</table>';
        $json = array(
         'type'     => 'success',
         'value'    => $frames);
        break;
        
        
    case 'baners':
        $db = new dbClass('index_baner');
        $item = $db->getAllValues();
        $count = $db->count();
        $frames = '<div class="popup__overlay">
        <div class="popup">
        <a href="#" onclick="PopupHidden();" class="popup__close">X</a>
        <h2>Выберите новое изображение</h2>
        <img id="upload_img" height="200" src="#">
        <div class="popup-form__row">
        <p class="red">Внимание! Загружаемое изображение должно быть формата JPEG и иметь размеры не менее 300 x 200</p>
        <form id="upload_form" name="index" enctype="multipart/form-data" action="" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="1500000">
        <input name="userfile" type="file"><input type="submit" value="Заменить"></form>
        </div></div></div>';
        $frames .= '<table class="visible"><tr><th>Название</th><th>Ссылка</th><th>Имя картинки</th><th>Картинка</th><th>Состояние</th></tr>';
        If ($count == 1)
        {
            $frames .= '<tr><td>'.$item->title.'</td><td><a href="/'.$item->url.'">'.$item->url.'</a></td><td><a href="/img/'.$item->src.'" target="_blank">'.$item->src.'</a></td>'.
                       '<td><button onclick="setUploadForm(\''.$item->id.'\', \''.$item->src.'\', \'index_baner\');">Заменить</button></td>'.
                       '<td><button id="state_btn_'.$item->id.'" onclick="setActiveFrame(\''.$item->id.'\', \''.$item->active.'\', \'index_baner\');">'.getTitleActBtn($item[$i]->active).'</button></td></tr>';
            
        }
        elseIf($count > 0)
        {
            For ($i=0;$i<$count;$i++)
            {
                $frames .= '<tr><td>'.$item[$i]->title.'</td><td><a target="_blank" href="/'.$item[$i]->url.'">'.$item[$i]->url.'</a></td><td><a href="/img/'.$item[$i]->src.'" target="_blank">'.$item[$i]->src.'</a></td>'.
                           '<td><div id="index_frame_'.$item[$i]->id.'"><button onclick="setUploadForm(\''.$item[$i]->id.'\', \''.$item[$i]->src.'\', \'index_baner\');">Заменить</button></div></td>'.
                           '<td><button id="state_btn_'.$item[$i]->id.'" onclick="setActiveFrame(\''.$item[$i]->id.'\', \''.$item[$i]->active.'\', \'index_baner\');">'.getTitleActBtn($item[$i]->active).'</button></td></tr>';
            }
        }
        $frames .= '</table>';
        $json = array(
         'type'     => 'success',
         'value'    => $frames);
        break;
        
        
        case 'm_course':
        $db = new dbClass('course');
        $course = $db->getById(intval($this->params[2]));
        $count = $db->count();
        If ($count == 0)
        {
            $json = array('type' => 'success', 'value' => 'Error');
        }
        else
        {
            $json = array
            (
                'type'     => 'success',
                'value'    => '<br>Разделитель дробной части - знак "." (<em class="red">точка</em>)<div id="errortext"></div><table><tr><td><h2>'.$course->title.' ('.$course->sign.')</h2></td></tr><tr><td><input id="course_value" type="text" value="'.round($course->value, 2).'"></td></tr><tr><td><div id="submitButton"><div class="button" onclick="UpdateCourse(\''.$course->id.'\');"><span>Сохранить</span></div></div></td></tr></table>'
            );
        }
        break;

}
    
 
$this->setResponse(json_encode($json), 0);
?>
