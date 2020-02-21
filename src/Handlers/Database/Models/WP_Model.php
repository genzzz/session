<?php
namespace Genzzz\Session\Handlers\Database\Models;

use Genzzz\Session\Handlers\Database\Models\Model;

class WP_Model extends Model
{
    private $columns = [
        'id' => '%s',
        'user_id' => '%d',
        'ip_address' => '%s',
        'session' => '%s',
        'last_activity' => '%d'
    ];

    public function __construct($db, string $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    public function get(string $id) : array
    {
        $query = "SELECT * FROM {$this->table} WHERE id LIKE %s;";

        $result = $this->db->get_row(
            $this->db->prepare(
                $query,
                $id
            ),
            ARRAY_A
        );

        if(blank($result))
            return [];

        return $result;
    }

    public function insert(array $data) : bool
    {
        return $this->db->insert(
            $this->table,
            $data,
            $this->get_columns_type($data)
        );
    }

    public function update(string $id, array $data) : bool
    {
        return $this->db->update(
            $this->table,
            $data,
            ['id' => $id],
            $this->get_columns_type($data),
            $this->get_columns_type(['id' => $id])
        );
    }

    public function delete(string $id) : bool
    {
        return $this->db->delete(
            $this->table,
            ['id' => $id],
            $this->get_columns_type(['id' => $id])
        );
    }

    public function cleanup(int $maxlifetime) : bool
    {
        $query = "DELETE FROM {$this->table} WHERE last_activity + %d < unix_timestamp();";
        
        $results = $this->db->query(
            $this->db->prepare(
                $query,
                $maxlifetime
            )
        );

        if(0 === $results)
            return true;
        
        return $results;
    }

    private function get_columns_type(array $columns)
    {
        $types = [];

        $keys = array_keys($columns);

        foreach($keys as $column){
            if(array_key_exists($column, $this->columns)){
                array_push($types, $this->columns[$column]);
            }
        }

        return $types;
    }
}