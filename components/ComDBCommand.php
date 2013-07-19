<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of _ComDBQuery
 *
 * @author ishibkikh
 */

class ComDBCommand
{
    
    static public function getAll($table, $params=null, $order='id', $desc=false)
    {
        if ($desc === true)
        {
            $point = ' DESC';
        }
        else
        {
            $point = NULL;
        }
        
        if ($params != null)
        {
            $sql = 'SELECT * FROM `'.$table.'` WHERE '.self::arrayToCondition($params).' ORDER BY `'.$order.'`'.$point.';';
        }
        else
        {
            $sql = 'SELECT * FROM `'.$table.'` ORDER BY `'.$order.'`'.$point.';';
        }
        return ComDBConnection::query($sql);
    }
    
    static public function getRow($table, $params)
    {
        $sql = 'SELECT * FROM `'.$table.'` WHERE '.self::arrayToCondition($params).' LIMIT 1;';
        $result = ComDBConnection::query($sql);
        return $result[0];
    }
    
    static public function delete($table, $params)
    {
        $sql = 'DELETE FROM `'.$table.'` WHERE '.self::arrayToCondition($params).';';
        return ComDBConnection::command($sql);
    }
    
    static public function update($table, $params, $condition)
    {
        $sql = 'UPDATE `'.$table.'` SET '.self::arrayToEnumeration($params).' WHERE '.self::arrayToCondition($condition).';';
        return ComDBConnection::command($sql);
    }
    
    static public function insert($table, $params)
    {
        $fields = null;
        $values = null;
        foreach ($params as $key => $value)
        {
            if ($fields == null)
            {
                $fields = '`'.$key.'`';
            }
            else
            {
                $fields .= ',`'.$key.'`';
            }
            if ($values == null)
            {
                $values = ':'.$key;
            }
            else
            {
                $values .= ',:'.$key;
            }
            ComDBConnection::setParam($key, $value);
        }
              
       $sql = 'INSERT INTO '.$table.' ('.$fields.') VALUES ('.$values.');';
       If (ComDBConnection::command($sql) != 0)
       {
            return ComDBConnection::getInsertId();
       }
       else
       {
            return false;
       }
    }
    
    
    static private function arrayToEnumeration($params)
    {
        $output = null;
        foreach ($params as $key => $value)
        {
            if ($output == null)
            {
                $output = '`'.$key.'`=:_'.$key;
            }
            else
            {
                $output .= ', `'.$key.'`=:_'.$key;
            }
            ComDBConnection::setParam('_'.$key, $value);
        }
        
        return $output;
    }
    
    static private function arrayToCondition($params)
    {
        $output = null;
        foreach ($params as $key => $value)
        {
            if ($output == null)
            {
                $output = '`'.$key.'`=:'.$key;
            }
            else
            {
                $output .= ' AND `'.$key.'`=:'.$key;
            }
            ComDBConnection::setParam($key, $value);
        }
        
        return $output;
    }
}

?>
