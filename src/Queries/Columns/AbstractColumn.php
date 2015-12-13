<?php

namespace Highideas\SqlToMigration\Queries\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

abstract class AbstractColumn
{
    protected $name;
    protected $type;
    protected $raw;
    protected $size = 0;
    protected $defaultSize = 0;
    protected $default = null;
    protected $splitColumn = [
        0 => 'unknown',
        1 => 'unknown',
        2 => 'undefined'
    ];

    abstract protected function defineDefault();
    abstract protected function match($column);

    public function __construct($column)
    {
        $this->raw = $column;
        $this->match($column);
        unset($this->splitColumn[0]);
        $this->prepare();
    }

    protected function prepare()
    {
        $this->name = $this->splitColumn[1];
        $this->type = $this->splitColumn[2];
        if ($this->hasDefault()) {
            $this->defineDefault();
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

    public function getDefault()
    {
        return $this->default;
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function isNullable()
    {
        return strpos(strtolower($this->getRaw()), 'not null') === false;
    }

    public function hasDefault()
    {
        return strpos(strtolower($this->getRaw()), 'default') !== false;
    }

    protected function setInvalidColumnException($message)
    {
        throw new InvalidColumnException(
            $this->getRaw(),
            $message
        );
    }

    public function getDefaultSize()
    {
        return $this->defaultSize;
    }
}
