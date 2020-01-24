<?php
namespace Genzzz\Session\Models;

abstract class Model
{
    protected $db;
    protected $table;

    abstract protected function get($id);

    abstract protected function insert($id, $ip, $lastActivity);

    abstract protected function update($id, $serializedSession, $lastActivity);
}