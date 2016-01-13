<?php

namespace Highideas\SqlToMigration\Queries\Statements\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;
use Highideas\SqlToMigration\Queries\Statements\Constraints\NotNull;
use Highideas\SqlToMigration\Queries\Statements\Constraints\DefaultValue;
use Highideas\SqlToMigration\Queries\Statements\Constraints\AutoIncrement;

abstract class Column implements ColumnInterface
{

    protected $default = null;
    protected $defaultRegex = '';
    protected $nullable = false;

    protected $name;
    protected $type;
    protected $raw;
    protected $size = 0;
    protected $defaultSize = 0;
    protected $splitColumn = [
        0 => 'unknown',
        1 => 'unknown',
        2 => 'undefined'
    ];

    abstract protected function match($column);

    public function __construct($column)
    {
        $this->setRaw($column);
        $this->setNullable(strpos(strtolower($this->getRaw()), 'not null') === false);
        $this->match($column);
        unset($this->splitColumn[0]);
        $this->prepare();
    }

    protected function prepare()
    {
        $this->name = $this->splitColumn[1];
        $this->type = $this->splitColumn[2];
        if ($this->hasDefault()) {
            $this->setDefault();
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function setRaw($raw)
    {
        $this->raw = $raw;
    }

    public function getDefaultSize()
    {
        return $this->defaultSize;
    }

    protected function setDefault()
    {

        foreach ($this->splitColumn as $value) {
            if (strpos(strtolower($value), 'default') !== false) {
                $this->default = preg_replace(
                    $this->getDefaultRegex(),
                    "$1",
                    $value
                );
                break;
            }
        }
        if (empty($this->default)) {
            throw new InvalidColumnException($this->getRaw(), 'Invalid Default Value.');
        }
    }

    public function setDefaultRegex($regex)
    {
        $this->defaultRegex = $regex;
    }

    public function getDefaultRegex()
    {
        return $this->defaultRegex;
    }

    public function hasDefault()
    {
        return strpos(strtolower($this->getRaw()), 'default') !== false;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function isNullable()
    {
        return $this->nullable;
    }

    public function setNullable($nullable)
    {
        $this->nullable = $nullable;
    }

    public function isAutoIncrement()
    {
        $autoIncrement = strpos(strtolower($this->getRaw()), 'auto_increment') !== false;
        $autoincrement = strpos(strtolower($this->getRaw()), 'autoincrement') !== false;
        return $autoIncrement || $autoincrement;
    }
}
