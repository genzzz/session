<?php
namespace Genzzz\Session;

final class SessionFunctions
{
    public function all()
    {
        return $_SESSION;
    }

    public function add($key, $value)
    {
        if(!$this->exists($key)){
            $_SESSION[$key] = $value;
        }
    }

    public function get($key)
    {
        if($this->exists($key)){
            return $_SESSION[$key];
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function has($key)
    {
        if(blank($_SESSION))
            return false;

        return ($this->exists($key) && $_SESSION[$key]) ? true : false;
    }

    public function exists($key)
    {
        if(blank($_SESSION))
            return false;

        return (array_key_exists($key, $_SESSION)) ? true : false;
    }

    public function remove($keys)
    {
        if(!is_array($keys)){
            if($this->exists($keys))
                unset($_SESSION[$keys]);

            return;
        }

        foreach($keys as $index => $key){
            if($this->exists($key)){
                unset($_SESSION[$key]);
            }
        }
    }

    public function clear()
    {
        $_SESSION = [];
    }

    public function remove_except(array $array)
    {
        if(blank($_SESSION))
            return;
        
        $session_keys = array_keys($_SESSION);

        $this->remove(array_diff($session_keys, $array));
    }

    public function remove_only(array $array)
    {
        if(blank($_SESSION))
            return;

        $session_keys = array_keys($_SESSION);

        $this->remove(array_intersect($session_keys, $array));
    }

    public function flash(string $key)
    {
        if(blank($_SESSION))
            return;

        if(($this->has($key))){
            $flash = $_SESSION[$key];
            $this->remove($key);
            return $flash;
        }
    }
}