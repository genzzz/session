<?php
namespace Genzzz\Session;

use Genzzz\Helpers\Encrypter;
use Genzzz\Helpers\Str;

trait Init
{
    private $id;
    private $encrypted_id;
    private $session;

    protected function get_the_id()
    {
        return $this->id;
    }

    protected function get_the_IP()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "127.0.0.1";
    }

    protected function last_activity()
    {
        return time();
    }

    protected function get_serialized_session()
    {
        return $this->serialize_session();
    }

    protected function set_id(string $id)
    {
        $this->encrypted_id = $id;
        $this->id = $this->decrypt_id();
        return $this;
    }

    protected function encrypter($encrypter)
    {
        $this->encrypter = $encrypter;
        return $this;
    }

    protected function set_cookie_name(string $name)
    {
        $this->cookie_name = $name;
        return $this;
    }

    protected function set_expiration(int $seconds)
    {
        $this->expiration = time() + $seconds;
        return $this;
    }

    protected function set_session($session)
    {
        $this->session = $this->unserialize_session($session);
        return $this;
    }

    protected function create()
    {
        $this->id = Str::random(26);
        $this->encrypted_id = $this->encrypt_id();
        $this->set_cookie();
        return $this;
    }

    protected function update()
    {
        $this->set_cookie();
        return $this;
    }

    private function set_cookie()
    {
        setcookie($this->cookie_name, $this->encrypted_id, $this->expiration, '/');
    }

    private function serialize_session()
    {
        if(filled($this->session))
            return serialize($this->session);

        return null;
    }

    private function unserialize_session($session)
    {
        if(filled($session))
            return unserialize($session);

        return null;
    }

    private function encrypt_id()
    {
        if($this->encrypter instanceof Encrypter)
            return $this->encrypter->encrypt($this->id);

        return $this->id;
    }

    private function decrypt_id()
    {
        if($this->encrypter instanceof Encrypter)
            return $this->encrypter->decrypt($this->encrypted_id);

        return $this->encrypted_id;
    }
}