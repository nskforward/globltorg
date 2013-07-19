<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CCache
 *
 * @author ishibkikh
 */
class ComCacheFile implements ICache
{
    static public function getDir()
    {
        return PATH.'data/cache/';
    }
    
    static public function delete($key)
    {
        $file = glob(self::getDir().self::encode($key).'.*');
        if (count($file)==0)
        {
            return false;
        }
        else
        {
            unlink($file[0]);
        }
    }
    
    static public function get($key)
    {
        if (ComConfigINI::get('app_cache_active') == 0)
        {
            return null;
        }
        $file = glob(self::getDir().self::encode($key).'.*');
        if (count($file)==0)
        {
            return null;
        }
        else
        {
            $last_modif = self::getLastModifTime($file[0]);
            $date = new DateTime();
            $cached_info = explode('.', $file[0]);
            if ($date->getTimestamp()-$last_modif > $cached_info[1])
            {
                unlink($file[0]);
                return null;
            }
            else
            {
                return file_get_contents($file[0]);
            }
        }
    }
    
    
    static private function getLastModifTime($filename)
    {
        return filemtime($filename);
    }
    
    
    
    
    static public function set($key, $value, $lifesec)
    {
        $src = self::getDir().self::encode($key).'.'.$lifesec;
        {
            if (file_put_contents($src, $value, LOCK_EX))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    
    static private function encode($key)
    {
        return ComSecurity::hash256($key);
    }
}

?>
