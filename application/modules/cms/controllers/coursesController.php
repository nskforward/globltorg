<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of coursesController
 *
 * @author ishibkikh
 */
class coursesController extends ComPController
{
    public function indexAction()
    {
        ComHTML::load('cms');
        ComHTML::title('Курсы валют');
        ComHTML::h1('Курсы валют');
        $records = ComDBCommand::getAll('course');
        ComHTML::append('<table class="table">');
        foreach ($records as $rec)
        {
            ComHTML::append('<tr><td>'.$rec->sign.' ('.$rec->title.')</td><td>'.$rec->value.'</td><td><a onclick="inputDlg(\'Изменение курса валюты '.$rec->sign.'\', \''.$rec->value.'\', \'/cms/processing/updatecourse/'.$rec->id.'\');return false;" href="#"><img src="/img/icons/edit.png" alt="edit" title="Редактировать"></a></td></tr>');
        }
        ComHTML::append('</table>');
        ComHTML::dispatch();
    }
}

?>
