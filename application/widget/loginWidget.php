<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function get_loginWidget()
{
  If (isSESS)
   {  
     return '<td>'.$_SESSION['user_name'].'</td><td><a href="/logout"><img src="img/checked_out.png" alt="Выход" title="Выход"></a></td>';
   }
  else
   {
    return '<td><a href="/login">Вход</a></td><td><a href="/login"><img src="img/checked_out.png" alt="Вход" title="Вход"></a></td>';
   }

}

function get_loginCSS()
{
    return NULL;
}

?>
