<?php
namespace Genzzz\Session;

use Genzzz\Session\SessionFunctions;
use Genzzz\Session\Handlers\Database\DatabaseHandler;
use Genzzz\Helpers\Encrypter;
use SessionHandlerInterface;

final class Init
{
    private $config;

    public function __construct()
    {
        $this->config = config('session');

        // FIXME: encryptor
        $this->set_cookie_name();
        $this->set_expire_on_close();
        $this->set_session_gc_probability();
        $this->set_cookie_params();
        $this->set_gc_maxlifetime();
        $this->set_session_driver();

        session_start();

        if(!isset($_SESSION['_destroy'])){
            $_SESSION['_destroy'] = time() + 60;
        }
        else{
            if($_SESSION['_destroy'] < time()){
                session_regenerate_id();
                $_SESSION['_destroy'] = time() + 60;
            }
        }

        $GLOBALS['genzzz_sess' . session_id()] = new SessionFunctions();
    }

    private function set_session_driver()
    {
        if(isset($this->config['driver'])){
            if(in_array($this->config['driver'], $this->drivers())){
                $handler = null;
    
                switch($this->config['driver']){
                    case 'database':
                        $handler = $this->database_handler_validation();
                        break;
                    case 'files':
                        $this->files_handler_validation();
                        break;
                    case 'redis':
                        $this->redis_handler_validation();
                        break;
                }
    
                if($handler instanceof SessionHandlerInterface){
                    session_set_save_handler($handler);
                    return;
                }
            }
        }
    }

    private function redis_handler_validation()
    {
        ini_set('session.save_handler', 'redis');
        session_save_path("tcp://{$this->config['redis']['host']}:{$this->config['redis']['port']}");
    }

    private function files_handler_validation()
    {
        ini_set('session.save_handler', 'files');

        if(!isset($this->config['files']) || !isset($this->config['files']['path']))
            return;

        if(!is_string($this->config['files']['path']) || $this->config['files']['path'] != '')
            return;

        if(!is_dir($this->config['files']['path']))
            return;

        session_save_path($this->config['files']['path']);
    }

    private function database_handler_validation()
    {
        if(!isset($this->config['database']))
            return;

        $database = $this->config['database'];

        if(count($database) != 3)
            return;

        if(!isset($database['connection']) || !isset($database['table']) || !isset($database['model']))
            return;

        if(!is_string($database['table']))
            return;

        return new DatabaseHandler($database);
    }

    private function set_session_gc_probability()
    {
        if(!is_array($this->config['probability']))
            return;

        if(blank($this->config['probability']))
            return;

        if(count($this->config['probability']) != 2)
            return;

        if(!is_int($this->config['probability'][0]) || !is_int($this->config['probability'][1]))
            return;

        list($gc_probability, $gc_divisor) = $this->config['probability'];

        ini_set('session.gc_probability', $gc_probability);
        ini_set('session.gc_divisor', $gc_divisor);
    }

    private function set_expire_on_close()
    {
        if(isset($this->config['expire_on_close']) && $this->config['expire_on_close'] === true)
            $this->config['lifetime'] = 0;
    }

    private function set_cookie_params()
    {
        if(!isset($this->config['lifetime']) || !is_int($this->config['lifetime']))
            return;

        $this->config['lifetime'] *= 60;

        if(isset($this->config['cookie'])){
            unset($this->config['cookie']['name']);
            $cookie = array_merge($this->config['cookie'], ['lifetime' => $this->config['lifetime']]);
            session_set_cookie_params($cookie);
        }
    }

    private function set_cookie_name()
    {
        if(!isset($this->config['cookie']['name']))
            return;
        
        if(is_string($this->config['cookie']['name']) && $this->config['cookie']['name'] != '')
            session_name($this->config['cookie']['name']);
    }

    private function set_gc_maxlifetime()
    {
        ini_set('session.gc_maxlifetime', $this->config['lifetime']);
    }

    private function drivers()
    {
        return ['files', 'database', 'redis'];
    }
}