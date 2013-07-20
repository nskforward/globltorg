<?php

/* * * * * * * * * * * * * * * * * * * * * * * *
 * DreamQ Modul Controller | Home page | 1.0.0 * 
 * * * * * * * * * * * * * * * * * * * * * * * *
 */
$this->protectAccess();
$this->setContentType('html');

$error = 0;

If ($_FILES['userfile']['error'] != 0)
{
    echo('Файл не загружен. Код ошибки: '.$_FILES['userfile']['error'].'<br>');
    $error = $error + 1;
}

$type = explode("/", $_FILES['userfile']['type']);
$ext = $type[1];

if ($ext == 'jpeg')
{
    $ext = 'jpg';
}


list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
If (($type != 2)and($type != 1)and($type != 3))
{
    echo('Загружать можно только картинки формата JPEG, GIF или PNG'.'<br>');
    $error = $error + 1;
}

If ((($width < 300)or($height < 200))and($this->params[2] == 'index_baner'))
{
    echo('Изображение должно быть размером не менее 300 x 200'.'<br>');
    $error = $error + 1;
}


$uploaddir = '../public/img/';
If (!is_dir($uploaddir)) throw new CustomException ('Not found path "uploads"');

switch ($this->params[2])
{
    case 'index_baner':
    $db = new dbClass($this->params[2]);
    $frame = $db->getById($this->params[3]);
    If ($db->count() == 0)
    {
        echo('Неверный URl к серверу'.'<br>');
        $error = $error + 1;
    }

    $uploadfile = $uploaddir . $frame->src;

    If ($error == 0)
    {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
        {
            $this->redirect('/cms/m_index');
        } 
        else
        {
            echo "Изображения нет на сервере".'<br>';
            $error = $error + 1;
        }
    }
    break;
    
    case 'index_frame':
    $db = new dbClass($this->params[2]);
    $frame = $db->getById($this->params[3]);
    If ($db->count() == 0)
    {
        echo('Неверный URl к серверу'.'<br>');
        $error = $error + 1;
    }

    $uploadfile = $uploaddir . $frame->src;

    If ($error == 0)
    {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
        {
            $this->redirect('/cms/m_index');
        } 
        else
        {
            echo "Изображения нет на сервере".'<br>';
            $error = $error + 1;
        }
    }
    break;
    
    case 'pages':
    $db = new dbClass($this->params[2]);
    $sb = intval($this->params[3]);
    $id = intval($this->params[4]);
    $rec = $db->getById($id);
    If ($db->count() == 0)
    {
        echo('Неверный URl к серверу'.'<br>');
        $error = $error + 1;
    }

    if ($sb == 0)
    {
        $src = $rec->lt_sb;
        if ($src == null)
        {
          $src = 'sb_pages_'.$rec->id.'_'.$sb.'.'.$ext;
          $db->updateValue($id, 'lt_sb', $src);
        }
    }
    if ($sb == 1)
    {
        $src = $rec->ld_sb;
        if ($src == null)
        {
          $src = 'sb_pages_'.$rec->id.'_'.$sb.'.'.$ext;
          $db->updateValue($id, 'ld_sb', $src);
        }
    }
    if ($sb == 2)
    {
        $src = $rec->r_sb;
        if ($src == null)
        {
          $src = 'sb_pages_'.$rec->id.'_'.$sb.'.'.$ext;
          $db->updateValue($id, 'r_sb', $src);
        }
    }

    
    $uploadfile = $uploaddir . $src;
    
    If ($error == 0)
    {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
        {
            $this->redirect('/cms/m_offers');
        } 
        else
        {
            echo "Изображения нет на сервере".'<br>';
            $error = $error + 1;
        }
    }
    break;
}   

?>
