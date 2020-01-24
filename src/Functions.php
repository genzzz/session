<?php
namespace Genzzz\Session;

trait Functions
{
    public function all()
    {
        return $this->session;
    }

    public function add($key, $value)
    {
        if(!$this->exists($key)){
            $this->session[$key] = $value;
        }
    }

    public function get($key)
    {
        if($this->exists($key)){
            return $this->session[$key];
        }
    }

    public function set($key, $value)
    {
        $this->session[$key] = $value;
    }

    public function has($key)
    {
        if(blank($this->session))
            return false;

        return ($this->exists($key) && $this->session[$key]) ? true : false;
    }

    public function exists($key)
    {
        if(blank($this->session))
            return false;

        return (array_key_exists($key, $this->session)) ? true : false;
    }

    public function remove($keys)
    {
        if(!is_array($keys)){
            if($this->exists($keys))
                unset($this->session[$keys]);

            return;
        }

        foreach($keys as $index => $key){
            if($this->exists($key)){
                unset($this->session[$key]);
            }
        }
    }

    public function clear()
    {
        $this->session = null;
    }

    public function remove_except(array $array)
    {
        if(blank($this->session))
            return;
        
        $session_keys = array_keys($this->session);

        $this->remove(array_diff($session_keys, $array));
    }

    public function remove_only(array $array)
    {
        if(blank($this->session))
            return;

        $session_keys = array_keys($this->session);

        $this->remove(array_intersect($session_keys, $array));
    }

    public function flash(string $key)
    {
        if(blank($this->session))
            return;

        if(($this->has($key))){
            $flash = $this->session[$key];
            $this->remove($key);
            return $flash;
        }
    }
}