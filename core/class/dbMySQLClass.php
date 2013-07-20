<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dbMySQLClass
 *
 * @author ishibkikh
 */
class dbMySQLClass {
    
   protected $link;
    
   protected function connect()
   {
      $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD);
      if (!$this->link) throw new CustomException('Error connecting to mysql server ['.mysqli_connect_error().']');
      mysqli_query($this->link,'set character_set_client="utf8"');
      mysqli_query($this->link,'set character_set_results="utf8"');
      mysqli_query($this->link,'set collation_connection="utf8_general_ci"');
      return True;
   }
   
   protected function selectDB()
   {
    mysqli_select_db($this->link, DB_DATABASE);
    If (mysqli_error($this->link)) throw new CustomException('Error select the DB: '.DB_DATABASE);
    return True;
   }
 
   protected function getCountFromResult($result)
   {
    return mysqli_num_rows($result);
   }
 
   protected function sql($sql, $type='MYSQLI_USE_RESULT')
   {
     $result = mysqli_query($this->link, $sql);
     If (mysqli_error($this->link)) throw new CustomException('Error running SQL-request: '.$sql.' ||'.mysqli_error($this->link));
     return $result;
   }
 
   protected function multiSql($sql)
   {
     $result = mysqli_multi_query($this->link, $sql);
     If (mysqli_error($this->link)) throw new CustomException('Error running SQL-request: '.$sql.' ||'.mysqli_error($this->link));
     return $result;
   }
   
   protected function disconnect()
   {
    mysqli_close($this->link);
   }
  
   protected function fetch_array($result)
   {
    return mysqli_fetch_array($result);
   }
  
   protected function fetch_obj($result)
   {
    return mysqli_fetch_object($result);
   }
  
   public function insert_id()
   {
    return mysqli_insert_id($this->link);
   }  
  
   protected function escape($str)
   {
    return mysqli_real_escape_string($this->link, $str);
   }
 
   protected function store_call($proc)
   {
    return $this->sql('CALL '.$proc, MYSQLI_STORE_RESULT);
   }
  
}

?>
