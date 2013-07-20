<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | JSON resources | 1.0.0  * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
$this->protectAccess(); 
$this->setContentType('json');
$json = array('type'=> 'error', 'value' => 'no content');

switch ($this->params[1])
 {
    case 'm_page':
    $db = new dbClass('pages');
    $values = $db->getFieldsArray();
    $values['title'] = $this->post['title'];
    $values['url'] = $this->post['url'];
    $values['content'] = $this->post['content'];
    $values['offer'] = 0;
    $db->updateRecord(intval($this->post['id']), $values);
    $json = array('type' => 'success');
    break;
    
    case 'm_continent':
    $db = new dbClass('continents');
    $values = $db->getFieldsArray();
    $values['title'] = $this->post['title'];
    $values['url'] = $this->post['url'];
    $values['content'] = $this->post['content'];
    $db->updateRecord(intval($this->post['id']), $values);
    $json = array('type' => 'success');
    break;

    case 'm_country':
    $db = new dbClass('places_tour');
    $values = $db->getFieldsArray();
    $values['title'] = $this->post['title'];
    $values['url'] = $this->post['url'];
    $values['content'] = $this->post['content'];
    $db->updateRecord(intval($this->post['id']), $values);
    $json = array('type' => 'success');
    break;

    case 'setactive':
    $db = new dbClass($this->params[2]);
    If ($this->params[4] == '1')
    {
        $NewState = 0;
    }
    else
    {
        $NewState = 1;
    }
    $res = $db->updateValue($this->params[3], 'active', $NewState);
    $json = array('type' => 'success', 'value' => $res);
    break;
    
    
    case 'removeorder':
    $db = new dbClass('orders');
    $res = $db->deleteById($this->params[2]);
    if ($res == true)
    {
        $json = array('type' => 'success');
    }
    else
    {
        $json = array('type' => 'error', 'value' => $res);
    }
    break;
    
    case 'update_course':
    $db = new dbClass('course');
    $res = $db->updateValue($this->params[2], 'value', $this->post['value']);
    If ($res == true)
    {
        $json = array('type' => 'success', 'value' => $res);
    }
    else
    {
        $json = array('type' => 'error', 'value' => $res);
    }
    break;
    
    case 'newoffer':
    $name = $this->post['name'];
    if (!$name)
    {
        $json = array('type' => 'error', 'value' => 'Поле "Название" должно быть заполнено');
        break;
    }
    $url =  strtolower($this->post['url']);
    $pattern = '/^([-_0-9a-z]+)$/';
    $n = preg_match($pattern, $url);
    if ($n == 0)
    {
        $json = array('type' => 'error', 'value' => 'Поле "URL" должно состоять только из латинских букв');
        break;
    }
    $db = new dbClass('pages');
    $rec = $db->getByValue('url', $url);
    If ($db->count()>0)
    {
        $json = array('type' => 'error', 'value' => 'Такой URL уже зарегистрирован в системе, используйте уникальный');
        break;
    }
    $values = $db->getFieldsArray();
    $values['url'] = $url;
    $values['title'] = $name;
    $values['content'] = '<h1>'.$name.'</h1>

<h2>Общее описание</h2>
<p>Абзац 1 с <strong>выделенным</strong> словом</p>

<h2>В стоимость входит</h2>
<p>Абзац 2 с <em>подкрашенным словом</em> словом</p>

<h2>Стоимость</h2>
<p>Абзац 3</p>';
    $db->insert($values);
    $json = array('type' => 'success', 'value' => 'Создано успешно. Для последующего редактирования, ещё раз зайдите на страницу "Спецпредложения" и найдите новый пункт в списке слева');
    break;
    
    
    case 'pageremove':
    $id = intval($this->params[2]);
    if ($id == 0)
    {
        $json = array('type' => 'error', 'value' => 'Внутренняя ошибка, страница не может быть удалена');
        break;
    }
    $db = new dbClass('pages');
    $rec = $db->getById($id);
    if ($rec->offer == 0)
    {
        $json = array('type' => 'error', 'value' => 'У вас недостаточно прав для удаления этой страницы');
        break;
    }
    
    $uploaddir = '../public/img/';
    unlink($uploaddir.$rec->lt_sb);
    unlink($uploaddir.$rec->ld_sb);
    unlink($uploaddir.$rec->r_sb);
    
    $db->deleteById($id);
    $json = array('type' => 'success');
    break;

 }
 
 $this->setResponse(json_encode($json), 0);
?>
