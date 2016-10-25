<?php

namespace Core\Table;

use \Core\Database\Database;
use \App;

class Table
{
    protected $table;
    protected $db;

    public function __construct($id = null)
    {
        $this->db = App::getInstance()->getDb();
        if (is_null($this->table)) {
            $parts     = explode('\\', get_class($this));
            $className = end($parts);
            $table     = strtolower(str_replace('Table', '', $className)) . 's';
        }

    }

    public function query($statement, $attributes = null, $one = false)
    {
        if ($attributes) {
            return $this->db->prepare(
                $statement,
                $attributes,
                str_replace('Table', 'Entity', get_class($this)),
                $one
            );
        } else {
            return $this->db->query(
                $statement,
                str_replace('Table', 'Entity', get_class($this)),
                $one
            );
        }
    }

    public function all()
    {
        return $this->query('SELECT * FROM ' . $this->table);
    }

    public function find($id)
    {
        return $this->query('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id], true);
    }

    public function create($fields)
    {
        $sql_parts  = [];
        $attributes = [];

        foreach ($fields as $k => $v) {
            //Get the Key of fields
            $sql_parts[]  = $k . ' = ?';
            //get the value
            $attributes[] = $v;
        }

        $sql_part     = implode(', ', $sql_parts);
        return $this->query('INSERT INTO ' . $this->table . ' SET ' . $sql_part, $attributes, true);
    }

    public function update($id, $fields)
    {
        $sql_parts  = [];
        $attributes = [];

        foreach ($fields as $k => $v) {
            //Get the Key of fields
            $sql_parts[]  = $k . ' = ?';
            //get the value
            $attributes[] = $v;
        }
        //Add id attribute to the end of array
        $attributes[] = $id;

        $sql_part     = implode(', ', $sql_parts);
        return $this->query('UPDATE ' . $this->table . ' SET ' . $sql_part . ' WHERE id = ? ', $attributes, true);
    }

    public function delete($id)
    {
        return $this->query('DELETE FROM ' . $this->table . ' WHERE id = ? ', [$id], true);
    }

    public function extract($key, $value)
    {
        $records = $this->all();
        $return = [];
        foreach ($records as $v) {
            $return[$v->$key] = $v->$value;
        }

        return $return;

    }
}
