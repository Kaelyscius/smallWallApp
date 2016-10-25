<?php

namespace Core\Entity;

/**
 * Parent of entities
 */
class Entity
{

    public function __get($key)
    {
        $method     = 'get' . ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }
}
