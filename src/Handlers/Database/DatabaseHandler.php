<?php
namespace Genzzz\Session\Handlers\Database;

use Genzzz\Session\Handlers\Database\Models\Model;
use SessionHandlerInterface;

class DatabaseHandler implements SessionHandlerInterface
{
    private $model, $exists = false;

    public function __construct(array $db)
    {
        $model = new $db['model']($db['connection'], $db['table']);
        if($model instanceof Model){
            $this->model = $model;
        }
    }

    public function open($path, $session_name) : bool
    {
        return true;
    }

    public function read($id) : string
    {
        $session = $this->model->get($id);

        if(blank($session)){
            return '';
        }

        $this->exists = true;

        if(filled($session['session'])){
            return $session['session'];
        }

        return '';
    }

    public function write($id, $session) : bool
    {
        $data = $this->get_default_data($session);

        if(!$this->exists){
            $data = array_merge($data, ['id' => $id]);
            return $this->model->insert($data);
        }

        return $this->model->update($id, $data);
    }

    public function close() : bool
    {
        return true;
    }

    public function destroy($id) : bool
    {
        return $this->model->delete($id);
    }

    public function gc($maxlifetime) : int
    {
        return $this->model->cleanup($maxlifetime);
    }

    private function get_default_data($session)
    {
        return [
            'ip_address' => $this->ip_address(),
            'session' => $session,
            'last_activity' => time()
        ];
    }

    private function ip_address()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "127.0.0.1";
    }

}