<?php
namespace Genzzz\Session\Handlers\Database\Models;

abstract class Model
{
    protected $db;
    protected $table = 'sessions';

    abstract protected function get(string $id) : array;

    abstract protected function insert(array $data) : bool;

    abstract protected function update(string $id, array $data) : bool;

    abstract protected function delete(string $id) : bool;

    abstract protected function cleanup(int $lifetime) : bool;
}