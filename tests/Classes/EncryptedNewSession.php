<?php
namespace Genzzz\Session\Tests\Classes;

use Genzzz\Helpers\Encrypter;
use Genzzz\Helpers\Str;
use Genzzz\Session\Controllers\Controller as BaseController;

class EncryptedNewSession extends BaseController
{
    public function __construct()
    {
        $this->encrypter = $this->test_encrypter();
        $this->set_cookie_name($this->cookie_name)->set_expiration($this->expiration)->create();
    }

    private function test_encrypter()
    {
        putenv("APP_KEY=" . Str::random(32));

        $encrypter = new Encrypter();

        return $encrypter;
    }

    public function the_id()
    {
        return $this->get_the_id();
    }

    public function the_IP()
    {
        return $this->get_the_IP();
    }

    public function the_serialized_session()
    {
        return $this->get_serialized_session();
    }

    public function the_last_activity()
    {
        return $this->last_activity();
    }
}