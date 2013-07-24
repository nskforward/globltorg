<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CDB
 *
 * @author ishibkikh
 */
class ComDBConnection
{
    static private $dbh = null, $is_trans=false;
    static public $params = array();
    
    static private function checkConnection()
    {
        if (self::$dbh == null)
        {
            self::$dbh = self::init(ComConfigINI::get('db_type'), ComConfigINI::get('db_database'), ComConfigINI::get('db_host'), ComConfigINI::get('db_user'), ComConfigINI::get('db_password'));
        }
    }
    
    static public function beginTransaction()
    {
        self::checkConnection();
        self::$is_trans = true;
        self::$dbh->beginTransaction();
    }
    
    static public function rollBack()
    {
        if (self::$is_trans)
        {
            self::$dbh->rollBack();
            self::$is_trans = false;
        }
    }
    
    static public function commit()
    {
        if (self::$is_trans)
        {
            self::$dbh->commit();
            self::$is_trans = false;
        }
    }

    static private function init($DbType, $DbName, $DbHost=null, $DbUser=null, $DbPassword=null)
    {
        try
            {
                switch ($DbType)
                {
                    case 'mysql':
                        $dbh = new PDO('mysql:host='.$DbHost.';dbname='.$DbName.';charset=utf8', $DbUser, $DbPassword);
                        $dbh->exec("set names utf8");
                        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        break;
                    
                    case 'sqlite': $dbh = new PDO($DbName);
                        break;
                    
                    case 'pgsql':  $dbh = new PDO('pgsql:host='.$DbHost.';dbname='.$DbName, $DbUser, $DbPassword);
                        break;
                    
                    default: throw new SysException('Undefined database type: "'.$DbType.'"');
                }
            }
            catch(PDOException $e)
            {
                throw new SysException($e->getMessage());
            }
        
        return $dbh;
    }
    
    static public function query($sql, $returnFormat = PDO::FETCH_OBJ)
    {
        try
            {
                self::checkConnection();
                $sth = self::$dbh->prepare($sql);
                
                If (count(self::$params)>0)
                {
                    foreach (self::$params as $key => $value)
                    {
                        $sth->bindValue($key, $value);
                    }
                }
                self::$params = array();
                $sth->execute();
                $sth->setFetchMode($returnFormat);
                if ($sth->rowCount() == 0)
                {
                    return false;
                }
                else
                {
                    return $sth->fetchAll();
                }
           }
            catch (PDOException $e)
            {
                throw new SysException($e->getMessage().' ['.$sql.']');
            }
    }
    
    static public function command($sql)
    {
        try
            {
                self::checkConnection();
                $sth = self::$dbh->prepare($sql);
                
                If (count(self::$params)>0)
                {
                    foreach (self::$params as $key => $value)
                    {
                        $sth->bindValue($key, $value);
                    }
                }
                self::$params = array();
                $sth->execute();
                return $sth->rowCount();
           }
            catch (PDOException $e)
            {
                throw new SysException($e->getMessage().' ['.$sql.']');
            }
    }
    
    static public function execList($multiSql)
    {
        try
            {
                self::checkConnection();
                self::$dbh->prepare($sql);
                return self::$dbh->exec($multiSql);
            }
            catch (PDOException $e)
            {
                throw new SysException($e->getMessage());
            }
    }
    
    static public function setParam($name, $value)
    {
        self::$params[':'.$name] = $value;
    }
    
    static public function getInsertId()
    {
        return self::$dbh->lastInsertId();
    }
}

?>
