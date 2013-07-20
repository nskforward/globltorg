<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of articleXMLClass
 *
 * @author ishibkikh
 */
class articleXMLClass {
    private $xml, $id;
    
    public function create($autor, $title, $public)
    {
        $src = '../application/userdata/article/template.xml';
        if (!file_exists($src)) throw new CustomException('Not found "'.$src.'"');
        $this->xml = simplexml_load_file($src);
        $this->autor_id = $autor;
        $db = new dbClass('article');
        $values = $db->getFieldsArray();
        $values['parent_id'] = $this->autor_id;
        $values['title'] = $title;
        $values['ts_create'] = $db->now();
        $values['ts_modif'] = $db->now();
        $values['block'] = 1;
        $values['status'] = 1;
        $values['public'] = $public;
        $this->id = $db->insert($values);
        $this->save();
    }
    
    public function open($id)
    {
        $src = '../application/userdata/article/'.intval($id).'.xml';
        if (!file_exists($src)) throw new CustomException('Not found "'.intval($id).'.xml"');
        $this->xml = simplexml_load_file($src);
        $this->id = $id;
        $db = new dbClass('article');
        return $db->getById($id);
    }
    
    public function drop($id)
    {
        $id = intval($id);
        $src = '../application/userdata/article/'.$id.'.xml';
        unlink($src);
        $db = new dbClass('article');
        $db->deleteById($id);
    }
    
    public function set($name, $value)
    {
        If (!$this->id) throw new CustomException('Setting an attribute in the XML is unloaded');
        $this->xml->{$name} = $value;
        
    }
    
    public function get($name)
    {
       If (!$this->id) throw new CustomException('Getting an attribute in the XML is unloaded');
       $result = $this->xml->xpath("//".$name);
       return $result[0];
    }
    
    public function save()
    {
        $this->xml->asXML('../application/userdata/article/'.$this->id.'.xml');
    }
    
    public function getId()
    {
        return $this->id;
    }
    
}

?>
