<?php
namespace Genzzz\Session;

final class Session
{
    public static function all()
    {
        return $_SESSION;
    }

    public static function add($key, $value)
    {
        if(!self::exists($key)){
            $_SESSION[$key] = $value;
        }
    }

    public static function get($key)
    {
        if(self::exists($key)){
            return $_SESSION[$key];
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function has($key)
    {
        if(blank($_SESSION))
            return false;

        return (self::exists($key) && $_SESSION[$key]) ? true : false;
    }

    public static function exists($key)
    {
        if(blank($_SESSION))
            return false;

        return (array_key_exists($key, $_SESSION)) ? true : false;
    }

    public static function remove($keys)
    {
        if(!is_array($keys)){
            if(self::exists($keys))
                unset($_SESSION[$keys]);

            return;
        }

        foreach($keys as $index => $key){
            if(self::exists($key)){
                unset($_SESSION[$key]);
            }
        }
    }

    public static function clear()
    {
        $_SESSION = [];
    }

    public static function remove_except(array $array)
    {
        if(blank($_SESSION))
            return;
        
        $session_keys = array_keys($_SESSION);

        self::remove(array_diff($session_keys, $array));
    }

    public static function remove_only(array $array)
    {
        if(blank($_SESSION))
            return;

        $session_keys = array_keys($_SESSION);

        self::remove(array_intersect($session_keys, $array));
    }

    public static function flash(string $key)
    {
        if(blank($_SESSION))
            return;

        if((self::has($key))){
            $flash = $_SESSION[$key];
            self::remove($key);
            return $flash;
        }
    }
}