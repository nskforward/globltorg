<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of coursesWidget
 *
 * @author ishibkikh
 */
class coursesWidget implements IWidget
{
    static public function getContent()
    {
        $records = ComDBCommand::getAll('course');
        $courses = '';
        $i = 0;
        foreach ($records as $rec)
        {
            if ($i == 0)
            {
                $courses .= $rec->sign.' '.$rec->value;
            }
            else
            {
                $courses .= ' | '.$rec->sign.' '.$rec->value;
            }
            $i++;
        }
        
        return $courses;
    }
}

?>
