<?php

class dbsqliteClass
{
    private $link;
    private $__count;
/*
   public function __construct()
   {
    
   }
*/
   private function connect()
   {
     $this->link = sqlite_open(DB_SQLITE, 0666, $error);
     if ($this->link == false)
       {
        throw new CustomException('Error connecting to sqlite server ['.$error.']');
       }
    return true;
   }
   
   public function ping()
   {
     return sqlite_libversion();
   }
   
   private function disconnect()
   {
     sqlite_close($this->link);
   }

   private function sql($sql)
   {
    $result = sqlite_query($this->link, $sql);
    If (sqlite_error_string($this->link)) throw new CustomException('Error running SQL-request: '.$sql.' ||'.sqlite_error_string($this->link));
    return $result;
   }

  private function __getCount($result)
  {
   return sqlite_num_rows($result);
  }
  
  public function count()
  {
    return $this->__count;
  }
  
  public function fetch_array($result)
  {
   return sqlite_fetch_array($result);
  }
  
  public function fetch_obj($result)
  {
    return sqlite_fetch_object($result);
  }
  
  public function insert_id()
  {
    return sqlite_last_insert_rowid($this->link);
  }
  
  public function escape($str)
  {
    return sqlite_escape_string($str);
  }
}

?>