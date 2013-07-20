<?php

/* * * * * * * * * * * * * * * * * * * * * * * * 
 * DreamQ Modul Controller | CMS page | 1.0.0* 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
 $this->protectAccess();
 
 If ($this->params[1] == null)
 {
     $this->params[1] = 'm_index';
 }
 
 Switch ($this->params[1])
 {
   case 'm_index':
       $this->setContentType('html');
       $this->setTitle('Стартовая страница');
       $this->content = $this->template->load("cms");
       $left = '<ul>';
       $left .= '<li onclick="LoadForm(\'\',\'frames\');">Фреймы</li>';
       $left .= '<li onclick="LoadForm(\'\',\'baners\');">Банеры</li>';
       $left .= '</ul>';
       $this->setVar('LEFT_PANEL', $left);
       $this->setVar('MAIN_PANEL', 'Страница не выбрана');
       $this->setResponse();
       break;
     
     
   case 'm_page':
       $this->setContentType('html');
       $this->setTitle('Страницы');
       $this->content = $this->template->load("cms");
       $db = new dbClass('pages');
       $items = $db->getByValue('offer', 0, 0);
       $count = $db->count();
       If ($count == 0)
       {
           $this->setVar('LEFT_PANEL', 'Данные отсутствуют');
           $this->setResponse();
           exit;
       }
       else
       {
           If ($count == 1)
           {
               $left = '<ul><li onclick="LoadPage('.$items->id.', \''.$this->params[1].'\');">'.$items->title.'</li></ul>';
           }
           else
           {
               $left = '<ul>';
               for($i=0;$i<$count;$i++)
               {
                   $left .= '<li onclick="LoadPage('.$items[$i]->id.', \''.$this->params[1].'\');">'.$items[$i]->title.'</li>';
               }
               $left .= '</ul>';
           }
           
           $this->setVar('LEFT_PANEL', $left);
           $this->setVar('MAIN_PANEL', 'Страница не выбрана');
           $this->setResponse();
       }
       
       break;
   
   
   case 'm_offers':
       $this->setContentType('html');
       $this->setTitle('Спецпредложения');
       $this->content = $this->template->load("cms");
       $db = new dbClass('pages');
       $items = $db->getByValue('offer', 1, 0);
       $count = $db->count();
       If ($count == 0)
       {
           $this->setVar('LEFT_PANEL', 'Данные отсутствуют');
           $this->setResponse();
           exit;
       }
       else
       {
           If ($count == 1)
           {
               $left = '<ul><li onclick="LoadPage('.$items->id.', \'m_page\');">'.$items->title.'</li></ul>';
           }
           else
           {
               $left = '<ul>';
               for($i=0;$i<$count;$i++)
               {
                   $left .= '<li onclick="LoadPage('.$items[$i]->id.', \'m_page\');">'.$items[$i]->title.'</li>';
               }
               $left .= '</ul>';
           }
           
           $this->setVar('LEFT_PANEL', $left);
           $this->setVar('MAIN_PANEL', '<h2>Создать новое</h2><div id="errortext"></div><form name="newoffer"><table><tr><td>Название</td><td><input name="name" type="text" value=""></td></tr><tr><td>URL</td><td><input name="url" type="text" value=""></td></tr><tr><td></td><td><button onclick="send_form(\'newoffer\');return false;">Создать</button></td></tr></table></form>');
           $this->setResponse();
       }
       
       break;       
       
   
   case 'm_country':
       $this->setContentType('html');
       $this->setTitle('Страны');
       $this->content = $this->template->load("cms");
       $db = new dbClass('places_tour');
       $items = $db->getAllValues();
       $count = $db->count();
       If ($count == 0)
       {
           $this->setVar('LEFT_PANEL', 'Данные отсутствуют');
           $this->setResponse();
           exit;
       }
       else
       {
           If ($count == 1)
           {
               $left = '<ul><li onclick="LoadPage('.$items->id.', \''.$this->params[1].'\');">'.$items->title.'</li></ul>';
           }
           else
           {
               $left = '<ul>';
               for($i=0;$i<$count;$i++)
               {
                   $left .= '<li onclick="LoadPage('.$items[$i]->id.', \''.$this->params[1].'\');scroll(0,0);">'.$items[$i]->title.'</li>';
               }
               $left .= '</ul>';
           }
           
           $this->setVar('LEFT_PANEL', $left);
           $this->setVar('MAIN_PANEL', 'Страница не выбрана');
           $this->setResponse();
       }
       
       break;
       
       
       
   case 'm_order':
       $this->setContentType('html');
       $this->setTitle('Заявки');
       $this->content = $this->template->load("cms");
       $db = new dbClass('orders');
       $items = $db->getAllValues('id', true);
       $count = $db->count();
       If ($count == 0)
       {
           $this->setVar('LEFT_PANEL', 'Данные отсутствуют');
           $this->setResponse();
           exit;
       }
       else
       {
           If ($count == 1)
           {
               $left = '<ul><li onclick="LoadForm('.$items->id.', \''.$this->params[1].'\');">'.$items->date_reg.'</li></ul>';
           }
           else
           {
               $left = '<ul>';
               for($i=0;$i<$count;$i++)
               {
                   $left .= '<li onclick="LoadForm('.$items[$i]->id.', \''.$this->params[1].'\');">'.$items[$i]->date_reg.'</li>';
               }
               $left .= '</ul>';
           }
           
           $this->setVar('LEFT_PANEL', $left);
           $this->setVar('MAIN_PANEL', 'Страница не выбрана');
           $this->setResponse();
       }
       
       break;
   
       
       
  case 'm_course':
       $this->setContentType('html');
       $this->setTitle('Курсы валют');
       $this->content = $this->template->load("cms");
       $db = new dbClass('course');
       $items = $db->getAllValues('id');
       $count = $db->count();
       If ($count == 0)
       {
           $this->setVar('LEFT_PANEL', 'Данные отсутствуют');
           $this->setResponse();
           exit;
       }
       else
       {
           If ($count == 1)
           {
               $left = '<ul><li onclick="LoadForm('.$items->id.', \''.$this->params[1].'\');">'.$items->sign.'</li></ul>';
           }
           else
           {
               $left = '<ul>';
               for($i=0;$i<$count;$i++)
               {
                   $left .= '<li onclick="LoadForm('.$items[$i]->id.', \''.$this->params[1].'\');">'.$items[$i]->sign.'</li>';
               }
               $left .= '</ul>';
           }
           
           $this->setVar('LEFT_PANEL', $left);
           $this->setVar('MAIN_PANEL', 'Страница не выбрана');
           $this->setResponse();
       }
       
       break;
   
   case 'm_continent':
       $this->setContentType('html');
       $this->setTitle('Наш мир');
       $this->content = $this->template->load("cms");
       $db = new dbClass('continents');
       $items = $db->getAllValues();
       $count = $db->count();
       If ($count == 0)
       {
           $this->setVar('LEFT_PANEL', 'Данные отсутствуют');
           $this->setResponse();
           exit;
       }
       else
       {
           If ($count == 1)
           {
               $left = '<ul><li onclick="LoadPage('.$items->id.', \''.$this->params[1].'\');">'.$items->title.'</li></ul>';
           }
           else
           {
               $left = '<ul>';
               for($i=0;$i<$count;$i++)
               {
                   $left .= '<li onclick="LoadPage('.$items[$i]->id.', \''.$this->params[1].'\');">'.$items[$i]->title.'</li>';
               }
               $left .= '</ul>';
           }
           
           $this->setVar('LEFT_PANEL', $left);
           $this->setVar('MAIN_PANEL', 'Страница не выбрана');
           $this->setResponse();
       }
       
       break;
       
   default: $this->SetNotFound(1);
 }
 
?>
