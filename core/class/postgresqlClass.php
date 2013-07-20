<?php

/**
 * DreamQ core modul 1.0.0
 * Global class postgresqlClass
 * Ivan Shibkikh
 */

class postgresqlClass
{
    private $link;
    private $table;
    private $__count;
    public $result;

  public function __construct($table)
   {
     $this->table   = $table;
   }

  private function connect()
   {
      $this->link = pg_connect("host=".DB_SERVER." port=5432 user=".DB_USER." password=".DB_PASSWORD);
      if (!$this->link) throw new CustomException('Error connecting to mysql server ['.mysqli_connect_error().']');
      mysqli_query($this->link,'set character_set_client="utf8"');
      mysqli_query($this->link,'set character_set_results="utf8"');
      mysqli_query($this->link,'set collation_connection="utf8_general_ci"');
      return True;
   }
 
 private function selectDB()
 {
    mysqli_select_db($this->link, DB_DATABASE);
    If (mysqli_error($this->link)) throw new CustomException('Error select the DB: '.$this->db_name);
    return True;
 }

 public function createDB($name)
   {
     $this->connect();
     $result = $this->sql('CREATE DATABASE '.$name);
     return $result;
     $this->disconnect();
   }
 
 public function createTable($name)
   {
     $this->connect();
     $this->selectDB();
     $filename = '../data/db_damp/'.$name.'.sql';
     If (!file_exists($filename)) throw new CustomException('Don\'t create table "'.$name.'". File '.$name.'.sql not found');
     $handle = fopen($filename, "r");
     $contents = fread($handle, filesize($filename));
     fclose($handle);
     $result = $this->multiSql($contents);
     return $result;
     $this->disconnect();
   }
   
 public function getById($id)
   {
     $this->connect();
     $this->selectDB();
     $result = $this->sql('SELECT * FROM `'.$this->table.'` WHERE `id`='.intval($id).' LIMIT 0,1;');
     $this->__count = mysqli_num_rows($result);
     if ($this->__count == 0) return false;
     else return $this->fetch_obj($result);
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
     
     $this->__count = mysqli_num_rows($this->result);
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
     $this->__count = mysqli_num_rows($this->result);
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
     $result = $this->sql('UPDATE `'.$this->table.'` SET '.$string.' WHERE `id` = '.intval($id));
     If (mysqli_error($this->link)) return false;
     else return true;
     $this->disconnect();
   }
  public function updateValue($id, $field, $value)
   {
     $this->connect();
     $this->selectDB();
     $result = $this->sql('UPDATE `'.$this->table.'` SET `'.$field.'`="'.$value.'" WHERE `id` = '.intval($id));
     If (mysqli_error($this->link)) return false;
     else return true;
     $this->disconnect();
   } 
   
  public function now()
  {
     return date("Y-m-d H:i:s");
  }
  
  public function date($d, $m, $y)
  {
     $timestamp = mktime(0, 0, 0, $m, $d, $y);
     return date("Y-m-d", $timestamp);
  }
    
  public function insert($values)
   {
     $this->connect();
     $this->selectDB();
     $string = '';
     foreach($values as $value)
     {
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
   }
   
  public function getFieldsArray()
  {
    $src = '../application/models/tablesMySQLModel.php';
    if(!is_file($src)) throw new CustomException('Not found: '.$src);
    require_once($src);
    $table = $this->table;
    return tablesMySQlModel::$table();
  }
   
  private function sql($sql)
   {
     $result = mysqli_query($this->link, $sql);
     //echo $sql;
     If (mysqli_error($this->link)) throw new CustomException('Error running SQL-request: '.$sql.' ||'.mysqli_error($this->link));
     return $result;
   }
   
  private function multiSql($sql)
   {
     $result = mysqli_multi_query($this->link, $sql);
     If (mysqli_error($this->link)) throw new CustomException('Error running SQL-request: '.$sql.' ||'.mysqli_error($this->link));
     return $result;
   }
 
  private function disconnect()
  {
    mysqli_close($this->link);
  }
  
  public function count()
  {
    return $this->__count;
  }

  private function fetch_array($result)
  {
    return mysqli_fetch_array($result);
  }
  
  public function fetch_obj($result)
  {
    return mysqli_fetch_object($result);
  }

  public function store_call($proc)
  {
    return $this->sql('CALL '.$proc, MYSQLI_STORE_RESULT);
  }

  public function insert_id()
  {
    return mysqli_insert_id($this->link);
  }

  public function escape($str)
  {
    return mysqli_real_escape_string($this->link, $str);
  }
}

?>
