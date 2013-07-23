<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComWebUser
 *
 * @author ishibkikh
 */
class ComWebUser implements IWebUser
{
    static private
            $login_page='/cms/login',
            $id=0,
            $name='Guest',
            $group='Guest',
            $isAuth = false,
            $lifetime = 86400;
    
    static public function init()
    {
        if (ComSession::isActive())
        {
            if (ComSession::getId() > 0)
            {
                self::$isAuth = true;
                self::$id = ComSession::getId();
                self::$name = ComSession::getName();
            }
        }
    }

    static public function registry($id, $name, $group, $remember)
    {
        self::$id = $id;
        self::$group = $group;
        self::$name = $name;
        self::$isAuth = true;
        If ($remember)
            ComSession::create($id, $name, self::$lifetime);
        else
            ComSession::create($id, $name, 0);
    }
    
    static public function isPrivateAccess()
    {
        if (!ComSession::isActive())
        {
            ComResponse::redirect(self::$login_page);
            return false;
        }
        else
        {
            return true;
        }
    }
    
    static public function checkAccess($section,$event)
    {
        $rec = ComDBCommand::getRow('access', array('user_id'=>  self::$id, 'section'=>$section, 'event'=>$event));
        if (!$rec)
        {
            return false;
        }
        else
        {
            return $rec->allow;
        }
    }

    static function runAsGuestIfNotRunning()
    {
        if (!ComSession::isActive())
        {
            ComSession::create(self::$id, self::$name, 0);
        }
    }

    static public function isAuth()
    {
        return self::$isAuth;
    }
    
    static public function destroy()
    {
        self::$isAuth = false;
        self::$id = 0;
        self::$name = 'Guest';
        self::$group = 'Guest';
        ComSession::destroy();
    }
    
    static public function getGroup()
    {
        return self::$group;
    }
    
    static public function getId()
    {
        return self::$id;
    }
    
    static public function getName()
    {
        return self::$name;
    }
}

?>
