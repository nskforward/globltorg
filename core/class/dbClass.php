<?php

/**
 * DreamQ core modul 1.0.0
 * Global class dbmysqlClass
 * Ivan Shibkikh
 */
require_once 'dbMySQLClass.php';

class dbClass extends dbMySQLClass
{
    private $table;
    private $__count;
    public $result;
  
  public function __construct($table)
   {
     $this->table   = $table;
   }
  
 public function importDamp($name)
   {
     $this->connect();
     $this->selectDB();
     $filename = '../data/db_damp/'.$name.'.sql';
     If (!file_exists($filename)) throw new CustomException('File '.$name.'.sql not found');
     $handle = fopen($filename, "r");
     $contents = fread($handle, filesize($filename));
     fclose($handle);
     $result = $this->multiSql($contents);
     return $result;
     $this->disconnect();
   }

public function getAvg($field, $sectable)
   { 
     $this->connect();
     $this->selectDB();
     $result = $this->fetch_obj($this->sql(
     'SELECT AVG('.$field.') as avg FROM `'.$this->table.'` f, `'.$sectable.'` s where f.`id` = s.`id`;'
     ));
     return $result->avg;
     $this->disconnect();
   }
 
 public function getAvgM($field, $sectable, $ffield, $fvalue)
   {
     $this->connect();
     $this->selectDB();
     $result = $this->fetch_obj($this->sql(
     'select AVG(`'.$field.'`) as avg from `'.$this->escape($this->table).'` f, `'.$sectable.'` s where f.`id` = s.`id` AND f.'.$ffield.' = '.$fvalue.';'
     ));
     return $result->avg;
     $this->disconnect();
   }
 
 public function getAvgMM($field, $sectable, $ttable, $ffield, $tfield, $tvalue)
   {
     $this->connect();
     $this->selectDB();
     $result = $this->fetch_obj($this->sql(
     'select AVG(`'.$field.'`) as avg from `'.$this->table.'` f, `'.$sectable.'` s, `'.$ttable.'` t '.
     'where f.`id` = s.`id` AND f.'.$ffield.' = t.id AND '.$tfield.' = '.$tvalue.';'
             ));
     return $result->avg;
     $this->disconnect();
   }
   
   
 public function getById($id)
   {
     $this->connect();
     $this->selectDB();
     $result = $this->sql('SELECT * FROM `'.$this->escape($this->table).'` WHERE `id`='.intval($id).' LIMIT 0,1;');
     $this->__count = $this->getCountFromResult($result);
     if ($this->__count == 0) return false;
     else return $this->fetch_obj($result);
     $this->disconnect();
   }
   
 public function getSize()
   {
     $this->connect();
     $this->selectDB();
     $result = $this->fetch_obj($this->sql('select count(*) as count from `'.$this->table.'`;'));
     return $result->count;
     $this->disconnect();
   }
 
  public function getLastRow($count=1)
   {
     $this->connect();
     $this->selectDB();
     $result = $this->sql('select * from `'.$this->table.'` order by `id` DESC LIMIT 0,'.$count.';');
     $this->__count = $this->getCountFromResult($result);
     If ($this->__count == 1)
     {
       return $this->fetch_obj($result);
     }
     elseIf ($this->__count > 1)
     {
       $res = array();
       for ($i=0; $i<$this->__count; $i++)
         {
            $res[$i] = $this->fetch_obj($result);
         }
       return $res; 
     }
     else return False;
     $this->disconnect();
   }
  
  public function getByIdM($id, $sectable, $f1, $f2)
   {
     $this->connect();
     $this->selectDB();
     $result = $this->sql('SELECT * FROM `'.$this->table.'` f, `'.$sectable.'` s WHERE f.id='.intval($id).' AND f.city_id = s.id LIMIT 0,1;');
     return $this->fetch_obj($result);
     $this->disconnect();
   }
 
 
 public function getAllValues($order="id", $desc=false)
   {
     $this->connect();
     $this->selectDB();
     If ($desc) $desc = 'DESC';
     else $desc='';
     $this->result = $this->sql('SELECT * FROM `'.$this->table.'` t1 ORDER BY t1.`'.$order.'` '.$desc.';');    
     $this->__count = $this->getCountFromResult($this->result);
     If ($this->__count == 0) return false;
     If ($this->__count == 1) return $this->fetch_obj($this->result);
     If ($this->__count > 1)
     {
       $result = array();
       for ($i=0; $i<$this->__count; $i++)
         {
            $result[$i] = $this->fetch_obj($this->result);
         }
       return $result;
     }
     $this->disconnect();
   }
   
   
 public function getByValue($field, $value, $count=1, $order="id", $desc = false)
   {
     $this->connect();
     $this->selectDB();
     $this->__count = 0;
     If ($count==0) $limit = "";
     else $limit = "LIMIT 0,".$count;
     If ($desc) $desc = 'DESC';
     else $desc='';
     
     If (is_string($value))
     $this->result = $this->sql('SELECT * FROM `'.$this->table.'` WHERE `'.$field.'`="'.$this->escape($value).'" ORDER BY `'.$order.'` '.$desc.' '.$limit.';');
     else
     $this->result = $this->sql('SELECT * FROM `'.$this->table.'` WHERE `'.$field.'`='.$this->escape($value).' ORDER BY `'.$order.'` '.$desc.' '.$limit.';');    
     
     $this->__count = $this->getCountFromResult($this->result);
     If ($this->__count == 0) return false;
     If ($this->__count == 1) return $this->fetch_obj($this->result);
     If ($this->__count > 1)
     {
       $result = array();
       for ($i=0; $i<$this->__count; $i++)
         {
            $result[$i] = $this->fetch_obj($this->result);
         }
       return $result;
     }
     $this->disconnect();
   }
   
 public function findByValue($field, $value, $max=10, $order="id")
   {
     $this->connect();
     $this->selectDB();
     $this->__count = 0;
     $this->result = $this->sql('SELECT * FROM `'.$this->table.'` WHERE `'.$field.'` LIKE "'.$this->escape($value).'%" ORDER BY `'.$order.'` LIMIT '.$max.';');
     $this->__count = $this->getCountFromResult($this->result);
     If ($this->__count == 0) return false;
     else
     {
         for ($i=0; $i<$this->__count; $i++)
         {
            $result[$i] = $this->fetch_obj($this->result);
         }
         return $result;
     }
     $this->disconnect();
   }
  
  public function updateRecord($id, $names)
   {
     $this->connect();
     $this->selectDB();
     $string = '';
     foreach($names as $key => $value)
     {
       if (isset($value))
          if (is_string($value))
              $string .= '`'.$this->escape($key).'`="'.$this->escape($value).'",';
          else
              $string .= '`'.$this->escape($key).'`='.$this->escape($value).',';
     }
     $string = substr($string, 0, strlen($string)-1);
     $this->sql('UPDATE `'.$this->table.'` SET '.$string.' WHERE `id` = '.intval($id));
     $this->disconnect();
   }
  public function updateValue($id, $field, $value)
   {
     $this->connect();
     $this->selectDB();
     If (is_string($value))
     {
        $sql = 'UPDATE `'.$this->table.'` SET `'.$field.'`="'.$value.'" WHERE `id` = '.intval($id);
     }
     else
        $sql = 'UPDATE `'.$this->table.'` SET `'.$field.'`= '.$value.' WHERE `id` = '.intval($id); 
     $result = $this->sql($sql);
     $this->disconnect();
     return $result;
   } 
   
  public function now()
  {
     return date("Y-m-d H:i:s");
  }
  
  public function date($d, $m, $y)
  {
     $timestamp = mktime(0, 0, 0, intval($m), intval($d), intval($y));
     return date("Y-m-d", $timestamp);
  }
    
  public function isLogin($field_user, $field_pass, $user, $password)
   {
     $this->connect();
     $this->selectDB();
     $result = $this->sql(
     'SELECT * from `'.$this->table.'` where `'.$this->escape($field_user).'`="'.$this->escape($user).'" AND `'.$this->escape($field_pass).'`= PASSWORD("'.$this->escape($password).'");'
     );
     $this->__count = $this->getCountFromResult($result);
     If ($this->__count == 1)
     {
         return $this->fetch_obj($result);
     }
     else return FALSE;
     $this->disconnect();
   }
  
  public function insert($values)
   {
     $this->connect();
     $this->selectDB();
     $string = '';
     foreach($values as $key => $value)
     {
       If ($key == 'password') $string .= 'PASSWORD("'.$this->escape($value).'"),';
       else
        If ($value)
        {
            If (is_string($value))
                $string .= '"'.$this->escape($value).'",';
            else
                $string .= $this->escape($value).',';
        }    
        else $string .= 'NULL,';
     }
     $string = substr($string, 0, strlen($string)-1);
     $this->sql('INSERT INTO `'.$this->table.'` VALUES('.$string.');');
     return $this->insert_id();
     $this->disconnect();
     //throw new CustomException('INSERT INTO `'.$this->table.'` VALUES('.$string.');');
   }
   
  public function getFieldsArray()
  {
    $src = '../application/models/tablesModel.php';
    if(!is_file($src)) throw new CustomException('Not found: '.$src);
    require_once($src);
    $table = $this->table;
    return tablesMySQlModel::$table();
  }
  
  public function deleteById($id)
  {
    $this->connect();
    $this->selectDB();
    $res = $this->sql('delete from `'.$this->table.'` where `id` = '.$id.';');
    $this->disconnect();
    return $res;
  }
   
 public function count()
  {
    return $this->__count;
  }

}

?>
