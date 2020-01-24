<?php
namespace Genzzz\Session\Controllers;

use Genzzz\Session\Init;
use Genzzz\Session\Functions;

class Controller
{
    use Init, Functions;

    protected $model;

    protected $table = 'sessions';
    protected $db;

    protected $cookie_name = 'test_cookie';
    protected $expiration = 3600;
    protected $encrypter;

    public function get_session()
    {
        global $session;

        $this->encrypter($this->encrypter);

        if(isset($_COOKIE[$this->cookie_name])){
            $this->set_id($_COOKIE[$this->cookie_name])->set_cookie_name($this->cookie_name)->set_expiration($this->expiration)->update();
            $db_session = $this->model->get($this->get_the_id());
            $this->set_session($db_session);

            $session = $this;
            return;
        }

        $this->set_cookie_name($this->cookie_name)->set_expiration($this->expiration)->create();
        $this->model->insert($this->get_the_id(), $this->get_the_IP(), $this->last_activity());

        $session = $this;
    }

    public function update_session()
    {
        $this->model->update($this->get_the_id(), $this->get_serialized_session(), $this->last_activity());
    }
}