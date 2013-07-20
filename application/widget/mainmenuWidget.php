<?php

/*
 * To change this template, choose Tools | Templates
  */
function get_mainmenuWidget()
{
  
  $template = '<a href="/home"><img src="img/home_2.png" alt="Главная страница" title="Главная страница"></a><a href="/armanag"><img src="img/article_16.png" alt="Статьи" title="Статьи"></a>';
  If (isSESS)
   {  
    $template .= '<a href="/person"><img src="img/acc_smile1.png" alt="Моё настроение" title="Моё настроение"></a><a href="/setmood"><img src="img/settings.png" alt="Настройки пользователя" title="Настройки пользователя"></a>';
   }
  else
   {
    $template .= '<a href="/reg"><img src="img/reg1.png" alt="Регистрация" title="Регистрация"></a>';
   }
  $template .= '<a href="/support"><img src="img/support_s.png" alt="support" title="Служба поддержки"></a>';
  return $template;
}

function get_mainmenuCSS()
{
    return NULL;
}

?>
