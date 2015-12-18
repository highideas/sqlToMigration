<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

abstract class AbstractConstraint implements ConstraintInterface {

    protected $raw;
    protected $splitStatement = [
        0 => 'unknown',
    ];

    abstract protected function match();

    public function __construct($column)
    {
        $this->setRaw($column);
        $this->match();
        unset($this->splitStatement[0]);
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
