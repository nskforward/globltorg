<?php

/*
 * general form class 1.0.0
  */

/**
 * @author Ivan Shibkikh ivan.sh@mail.com
 */
class formClass
 {
  public $form, $js, $src, $name;
    
 public function __construct($name)
{
  $this->src = '../application/userdata/validator/'.$name.'Validator.xml';
  if(!is_file($this->src)) throw new CustomException('Not found: '.$this->src);
  $this->name = $name;
 }

private function repVar($value)
{
    $pattern = '/\{([-_0-9A-Z]+)\}/';
    $n = preg_match_all($pattern, $value, $matches);
    if ($n > 0)
        For ($i=1; $i<=$n; $i++)
        {
         $value = str_replace ('{'.$matches[1][0].'}', '<!--'.$matches[1][0].'-->', $value);
        }
    return $value;    
}

public function getHTML()
{
  $xml   = simplexml_load_file($this->src);
  $this->form = '';
  if ($xml['info'] <> 'false')
  {
      $this->form .= '<p>Поля со знаком<em class="red">*</em> обязательны для заполнения</p>';
  }
  $this->form .= '<div id="errortext"></div><form class="'.$xml['class'].'" name="'.$this->name.'" action="'.$xml['action'].'" method="'.$xml['method'].'" onSubmit="" autocomplete="off"><table>';
  $this->js = '<script type="text/javascript" src="/js/api.js?rand=0.01"></script>';
  $this->js.= '<script type="text/javascript">function checkForm(){var el,elName,value,type,form;error=0;form=document.forms["'.$this->name.'"];for(var i = 0;i<form.length;i++){el=form.elements[i];elName=el.nodeName.toLowerCase();value=$.trim(el.value);';
  
  foreach ($xml->field as $element)
    switch ($element['type'])
  {
   case "text":         $this->setInputText($element['name'], $element, $element['req'], $element['min'], $element['max'], $element['value']); break;
   case "alpha":        $this->setInputTextA($element['name'], $element, $element['req'], $element['min'], $element['max']); break;
   case "alpha-number": $this->setInputTextAN($element['name'], $element, $element['req'], $element['min'], $element['max']); break;
   case "number":       $this->setInputNumber($element['name'], $element, $element['req'], $element['min'], $element['max']); break;
   case "strings-alpha":$this->setInputTextSA($element['name'], $element, $element['req'], $element['min'], $element['max'], $element['ausug']); break;
   case "password":     $this->setInputPass($element['name'], $element, $element['req'], $element['min'], $element['max']); break;
   case "repassword":   $this->setInputRePass($element['name'], $element['parent'], $element, $element['req'], $element['max']); break;
   case "email":        $this->setInputEmail($element['name'], $element, $element['req'], $element['max']); break;
   case "submit":       $this->setSubmit($element, $element['cancel']); break;
   case "captcha":      $this->setCaptcha($element['name'], $element, $element['max']); break;
   case "date":         $this->setSelectDates($element['name'], $element['req'], $element, intval($element['year_start']), intval($element['year_stop'])); break;
   case "checkbox":     $this->setCheckbox($element['name'], $element['selected'], $element); break;
   case "radio":        $this->setRadioGroup($element['name'], $element['req'], $element['values'], $element['selected'], $element); break;
   case "label":        $this->setLabel($element['name'], $element['value'], $element['src'], $element); break;
   case "multilinetext":$this->setMLText($element['name'], $element['req'], $element['min'], $element['max'], $element['value'], $element); break;
   case "list":         $this->setList($element['name'], $element['req'], $element['textFile'], $element['selected'], $element); break;
   case "hidden":       $this->setHidden($element['name'], $element['max'], $element['value']); break;
   case "anytext":      $this->setAnyText($element['name'], $element, $element['req'], $element['min'], $element['max']); break;
   case "time":         $this->setTimeText($element['name'], $element, $element['req'], $element['min'], $element['max']); break;
   case "phone":        $this->setPhoneText($element['name'], $element, $element['req'], $element['min'], $element['max']); break;
  }
  $this->form .= "</table></form>";
  $this->js .= '}if(error == 0){send_anketa("'.$this->name.'", "'.$xml['action'].'");}}</script>';
  $general = $this->js.$this->form;
  return $general;
} 

public function setPhoneText($name, $title, $req, $min, $max)
{
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'")&(value.length<'.$min.')){showmessage("Длина значения не может быть меньше '.$min.' в поле [ '.$title.' ]");break;}';
    $this->js .= 'if(el.name=="'.$name.'"){var Pattern=/^([ +()-,0-9]+)$/i;if(!Pattern.test(value)){showmessage("Поле [ '.$title.' ] принимает значения: цифры, знаки +,()- .");break;}}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
}

public function setTimeText($name, $title, $req, $min, $max)
{
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'")&(value.length<'.$min.')){showmessage("Длина значения не может быть меньше '.$min.' в поле [ '.$title.' ]");break;}';
    $this->js .= 'if(el.name=="'.$name.'"){var Pattern=/^([ .-:,0-9а-яА-Яa-zA-Z]+)$/i;if(!Pattern.test(value)){showmessage("Поле [ '.$title.' ] принимает значения: буквы, цифры, знаки ,:- .");break;}}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
}

public function setAnyText($name, $title, $req, $min, $max)
{
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'")&(value.length<'.$min.')){showmessage("Длина значения не может быть меньше '.$min.' в поле [ '.$title.' ]");break;}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
}


public function setList($name, $req, $textFile, $selected, $title)
{
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><select name="'.$name.'"><!--SELECT_OPTIONS_'.mb_strtoupper($name,'UTF-8').'--></select></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><select name="'.$name.'"><!--SELECT_OPTIONS_'.mb_strtoupper($name,'UTF-8').'--></select></td></tr>';
  
  $src = '../application/userdata/formselect/'.$textFile;
  if(!file_exists($src)) throw new CustomException('Not found: '.$textFile);
  $lines = file($src);
  $count = count($lines);
  $options = '';
  For ($i=0;$i<$count;$i++)
  {
      $opt = explode("\=", $lines[$i]);
      $options .= '<option value="'.$opt[0].'">'.$opt[1].'</option>';
  }
  $this->form = preg_replace('<!--SELECT_OPTIONS_'.mb_strtoupper($name,'UTF-8').'-->', $options, $this->form);
}

public function setRadioGroup($name, $req, $values, $selected, $title)
{
  $groups = explode("|", $values);
  $html= "<table><tr>";
  foreach ($groups as $grop)
  {
   $params = explode("=", $grop);
   $field = $params[0];
   $value = $params[1];
   If ($selected == $value)
   {
       $html .= '<td><input name="'.$name.'" type="radio" value="'.$value.'" checked></td><td>'.$field.'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
   }
   else
   {
       $html .= '<td><input name="'.$name.'" type="radio" value="'.$value.'"></td><td>'.$field.'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
   }
  }
  $html .= '</tr></table>';
  
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td>'.$html.'</td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&($("input:radio[name='.$name.']:checked").val()==undefined)){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td>'.html.'</td></tr>';
}


public function setMLText($name, $req, $min, $max, $value, $title)
{
  if ($value)
      $value = $this->repVar($value);
  else 
      $value = '';
      
   If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><textarea name="'.$name.'">'.$value.'</textarea></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'")&(value.length<'.$min.')){showmessage("Длина значения не может быть меньше '.$min.' в поле [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'")&(value.length>'.$max.')){showmessage("Длина значения не может быть меньше '.$min.' в поле [ '.$title.' ]");break;}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><textarea name="'.$name.'">'.$value.'</textarea></td></tr>';
}

public function setInputText($name, $title, $req, $min, $max, $value)
{
  $pattern = '/^\{([-_0-9A-Z]+)\}$/';
  $n =preg_match_all($pattern, $value, $matches);
  if ($n > 0) $value = '<!--'.$matches[1][0].'-->';
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="'.$value.'" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'")&(value.length<'.$min.')){showmessage("Длина значения не может быть меньше '.$min.' в поле [ '.$title.' ]");break;}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="text" value="'.$value.'" maxlength="'.$max.'"></td></tr>';
}

public function setHidden($name, $max, $value)
{
  $value = $this->repVar($value);
  $this->form .= '<tr><td></td><td><input name="'.$name.'" type="hidden" value="'.$value.'"></td></tr>';
 }


public function setLabel($name, $value, $src, $title)
{
    $value = $this->repVar($value);
    If ($src)
    {
        $src = $this->repVar($src);
        $this->form .= '<tr><td>'.$title.'</td><td><div class="nodecorat"><a href="'.$src.'"><b>'.$value.'</b></a></div></td></tr>';
    }
    else
    $this->form .= '<tr><td>'.$title.'</td><td><div class="nodecorat">'.$value.'</div></td></tr>';
}

public function setCheckbox($name, $selected, $title)
{
    If ($selected)
    {
        If ($selected == 'true') $selected = 'checked="checked"';
        else
        $selected = $this->repVar($selected);
    }    
        
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="checkbox" '.$selected.'></td></tr>';
}

public function setSelectDates($name, $req, $title, $yb, $ye)
{
  $days = '<select name="'.$name.'_d" class="date"><option value=""></option>';
  for ($i=1;$i<32;$i++) $days .= '<option value="'.$i.'">'.$i.'</option>';
  $days .= '</select>';
  $years = '<select name="'.$name.'_y" class="date"><option value=""></option>';
  for ($i=$yb;$i<=$ye;$i++) $years .= '<option value="'.$i.'">'.$i.'</option>';
  $years .= '</select>';
  $months = '<select name="'.$name.'_m" class="date"><option value=""></option>';
  for ($i=1;$i<13;$i++) $months .= '<option value="'.$i.'">'.$this->keytomonth($i).'</option>';
  $months .= '</select>';
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td>'.$days.' '.$months.' '.$years.'</td></tr>';
    $this->js .= 'if((el.name=="'.$name.'_d")&(value=="")){showmessage("Не выбран день в полях [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'_m")&(value=="")){showmessage("Не выбран месяц в полях [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'_y")&(value=="")){showmessage("Не выбран год в полях [ '.$title.' ]");break;}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td>'.$days.' '.$months.' '.$years.'</td></tr>';
}

public function setInputTextAN($name, $title, $req, $min, $max)
{
  If ($req)
   {   
    $min = (int) $min;
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if(el.name=="'.$name.'"){var Pattern=/^([a-z][\w]{'.($min-1).',})$/i;if(!Pattern.test(value)){showmessage("Поле [ '.$title.' ] принимает значения:<br>- Только буквы латинского алфавита, цифры, знак подчёркивания<br>- Длина текста должна быть в интервале от '.$min.' до '.$max.' символов<br>- Самый первый символ не должен начинаться с цифры");break;}}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
}

public function setInputNumber($name, $title, $req, $minvalue, $maxvalue)
{
  If ($req)
   {   
    $min = (int) $min;
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="" maxlength="20"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if(el.name=="'.$name.'"){var Pattern=/^([0-9]+){'.$minvalue.','.$maxvalue.'}$/i;if(!Pattern.test(value)){showmessage("Поле [ '.$title.' ] принимает только положительные целочисленные значения длинной от '.$minvalue.' до '.$maxvalue.'");break;}}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
}

public function setInputTextSA($name, $title, $req, $min, $max, $ausug)
{
  If ($req)
   {   
    if ($ausug)
        {
            $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><div id="suggest"><input name="'.$name.'" onkeyup="suggest(\''.$name.'\', this.value, \''.$ausug.'\');" onblur="fill(\''.$name.'\', this.value);" type="text" value="" maxlength="'.$max.'">';
            $this->form .= '<div class="suggestionsBox" id="suggestions" style="display: none;"><img src="img/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow"><div class="suggestionList" id="suggestionsList">&nbsp;</div></div></div></td></tr>';
        }
    else    
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if(el.name=="'.$name.'"){var Pattern=/^([-, a-zA-Zа-яёА-Я]{'.$min.',})$/i;if(!Pattern.test(value)){showmessage("Поле [ '.$title.' ] принимает значения:<br>- Только буквы, тире, запятую или пробел<br>- Минимальная длина текста '.$min.' символа");break;}}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input '.$odent.' name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
}

public function setInputTextA($name, $title, $req, $min, $max)
{
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if(el.name=="'.$name.'"){var Pattern=/^([a-zа-яё]{'.$min.',})$/i;if(!Pattern.test(value)){showmessage("Поле [ '.$title.' ] принимает значения:<br>- Только буквы<br>- Минимальная длина текста '.$min.' символа");break;}}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
}


public function setInputPass($name, $title, $req, $min, $max)
{
  If ($req == "true")
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="password" value="" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(elName=="input")&(el.type=="password")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'")&(value.length<'.$min.')){showmessage("Длина значения не может быть меньше '.$min.' в поле [ '.$title.' ]");break;}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="password" value="" maxlength="'.$max.'"></td></tr>';
}

public function setInputRePass($name, $parent, $title, $req, $max)
{
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="password" value="" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(elName=="input")&(el.type=="password")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if((el.name=="'.$name.'")&(elName=="input")&(value!=form.'.$parent.'.value)){showmessage("Не совпадает пароль в поле [ '.$title.' ]");break;}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="password" value="" maxlength="'.$max.'"></td></tr>';
}

public function setInputEmail($name, $title, $req, $max)
{
  If ($req)
   {   
    $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
    $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
    $this->js .= 'if(el.name=="'.$name.'"){var Pattern=/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i; if (!Pattern.test(value)){showmessage("Неправильный формат значения в поле [ '.$title.' ]");break;}}';
   }
  else
    $this->form .= '<tr><td>'.$title.'</td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
}

public function setCaptcha($name, $title, $max)
 {
   $this->form .= '<tr><td></td><td><table><tr><td><img id="captcha" src="/captcha" name="cod"></td><td><h6 onclick="ReCaptcha();">Обновить</h6></td></tr></table></td></tr>';
   $this->form .= '<tr><td>'.$title.'<em class="red">*</em></td><td><input name="'.$name.'" type="text" value="" maxlength="'.$max.'"></td></tr>';
   $this->js .= 'if((el.name=="'.$name.'")&(value=="")){showmessage("Не заполнено поле [ '.$title.' ]");break;}';
 }

public function setSubmit($title, $cansel)
 {
   if ($cansel)
   {
       $cansel = $this->repVar($cansel);
       $this->form .= '<tr><td></td><td><table><tr><td><div id="submitButton"><div class="button" onclick="checkForm();"><span>'.$title.'</span></div></div></td><td><a href="'.$cansel.'">Отмена</a></td></tr></table></td></tr>';
   }
   else
    $this->form .= '<tr><td></td><td><div id="submitButton"><div class="button" onclick="checkForm();"><span>'.$title.'</span></div></div></td></tr>';
 }
  
private function keytomonth($key)
{
  switch ($key)
  {
     case 1: return 'январь'; break;
     case 2: return 'февраль'; break;
     case 3: return 'март'; break;
     case 4: return 'апрель'; break;
     case 5: return 'май'; break;
     case 6: return 'июнь'; break;
     case 7: return 'июль'; break;
     case 8: return 'август'; break;
     case 9: return 'сентябрь'; break;
     case 10: return 'октябрь'; break;
     case 11: return 'ноябрь'; break;
     case 12: return 'декабрь'; break;
  }
}

}
?>