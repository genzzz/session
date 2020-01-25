<?php
namespace Genzzz\Session\Tests\Classes;

use Genzzz\Helpers\Encrypter;
use Genzzz\Session\Controllers\Controller as BaseController;

class EncryptedExistedSession extends BaseController
{
    public function __construct()
    {
        $this->encrypter = $this->test_encrypter()[0];
        $this->set_id($this->test_encrypter()[1])->set_cookie_name($this->cookie_name)->set_expiration($this->expiration)->update();

        $array = serialize([
            'testkey' => 'testvalue1',
            'newkey' => 'newvalue1'
        ]);

        $this->set_session($array);
    }

    private function test_encrypter()
    {
        putenv("APP_KEY=12345678901234567890123456789012");
        $encrypter = new Encrypter();
        $encrypted_string = $encrypter->encrypt('12345678901234567890123456');

        return [$encrypter, $encrypted_string];
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