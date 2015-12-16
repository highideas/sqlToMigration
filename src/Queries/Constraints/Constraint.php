<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Queries\Constraints\ConstraintInterface;

class Constraint {

    use NotNull;
    use DefaultValue;
    use AutoIncrement;

    protected $raw;
    protected $splitColumn = [
        0 => 'unknown',
        1 => 'unknown',
        2 => 'undefined'
    ];

    public function __construct($column)
    {
        $this->setRaw($column);
        unset($this->splitColumn[0]);
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
