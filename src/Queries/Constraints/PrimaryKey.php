<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

class PrimaryKey
{

    protected $columns =[];
    protected $raw;
    protected $splitStatement = [
        0 => 'unknown',
    ];

    protected function match()
    {
        preg_match(
            "/(?=[`]*([a-zA-Z-_]+)[`]*.*PRIMARY KEY)|(?<=PRIMARY KEY)\s*\((['|`|\"]+.+['|`|\"]+)\)/i",
            $this->getRaw(),
            $this->splitStatement
        );

        if (empty($this->splitStatement)) {
            throw new InvalidColumnException($this->getRaw(), 'Invalid Column.');
        }
        $this->defineColumns();
    }

    protected function defineColumns()
    {
        if (!empty($this->splitStatement[2])) {
            $columns = explode(',', str_replace('`', '', $this->splitStatement[2]));
            array_map([$this, 'appendKey'], $columns);
            return;
        }
        if (!empty($this->splitStatement[1])) {
            $this->appendKey($this->splitStatement[1]);
        }
    }

    public function checkColumn($column)
    {
        $this->setRaw($column);
        $this->match();
        unset($this->splitStatement[0]);
    }

    public function appendKey($key)
    {
        $this->columns[$key] = $key;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function setRaw($raw)
    {
        $this->raw = $raw;
    }

    public function isAutoIncrement()
    {
        $auto_increment = strpos(strtolower($this->getRaw()), 'auto_increment') !== false;
        $autoincrement = strpos(strtolower($this->getRaw()), 'autoincrement') !== false;
        return $auto_increment || $autoincrement;
    }
}
