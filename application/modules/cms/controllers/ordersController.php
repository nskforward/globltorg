<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ordersController
 *
 * @author ishibkikh
 */
class ordersController extends ComPController
{
    public function indexAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Заявки');
        ComHTML::h1('Заявки');
        $records = ComDBCommand::getAll('orders', null, 'id', true);
        ComHTML::append('<table class="table">');
        ComHTML::append('<tr><th>ID</th><th>Дата</th><th>Клиент</th><th>Хочет в</th><th>Из</th><th>Когда</th><th>Класс</th><th>Страховка</th><th>Кол-во человек</th><th>Кол-во ночей</th><th>Отель звёзд</th></tr>');
        $i = 0;
        foreach ($records as $rec)
        {
            if ($rec->air_class_business !== null)
            {
                $air_class = ($rec->air_class_business == 1)?'бизнес':'эконом';
            }
            else $air_class = ' - ';
            $insurance = ($rec->insurance)?'есть':' - ';
            ComHTML::append('<tr><td><a href="#" onclick="loadForm(\'/cms/architect/getorder/'.$rec->id.'\');return false;">'.$rec->id.'</a></td><td>'.$rec->date_reg.'</td><td>'.$rec->client_name.'</td><td>'.$rec->city_in.'</td><td>'.$rec->city_out.'</td><td>'.$rec->date_out.'</td><td>'.$air_class.'</td><td>'.$insurance.'</td><td>'.$rec->men_count.'</td><td>'.$rec->night_count.'</td><td>'.$rec->category.'</td><td><a href="#" onclick="confirmDlg(\'Удалить заявку ['.$rec->id.']?\',\'/cms/processing/deleteorder/'.$rec->id.'\');return false;"><img src="/img/icons/remove.png" alt="Remove" title="Удалить"></a></td></tr>');
            $i++;
        }
        ComHTML::append('</table>');
        ComHTML::p('Всего заявок: <b>'.$i.'</b>');
        ComHTML::dispatch();
    }
}

?>
