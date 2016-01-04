<?php

namespace Highideas\SqlToMigration\Collections;

class Collection
{
    protected $collection = [];

    public function add($key, $value)
    {
        $this->collection[$key] = $value;
    }

    public function exist($key)
    {
        return array_key_exists($key, $this->collection) !== false;
    }

    public function get($key)
    {
        return $this->collection[$key];
    }

    public function getAll()
    {
        return $this->collection;
    }
}
