<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

abstract class AbstractConstraint implements ConstraintInterface {

    protected $name;
    protected $type;
    protected $raw;

    abstract protected function match($column);

    public function __construct($column)
    {
        $this->setRaw($column);
        $this->match($column);
        unset($this->splitColumn[0]);
        $this->setName($this->splitColumn[1]);
        $this->setType($this->splitColumn[2]);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getType($type)
    {
        $this->type = $type;
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function setRaw($raw)
    {
        $this->raw = $raw;
    }
}
