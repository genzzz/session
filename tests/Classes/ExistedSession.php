<?php
namespace Genzzz\Session\Tests\Classes;

use Genzzz\Session\Controllers\Controller as BaseController;
use Genzzz\Helpers\Str;

class ExistedSession extends BaseController
{
    public function __construct()
    {
        $this->set_id(Str::random(26))->set_cookie_name($this->cookie_name)->set_expiration($this->expiration)->update();

        $array = serialize([
            'testkey' => 'testvalue',
            'newkey' => 'newvalue'
        ]);

        $this->set_session($array);
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