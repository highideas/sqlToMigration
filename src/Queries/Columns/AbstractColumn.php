<?php

namespace Highideas\SqlToMigration\Queries\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;
use Highideas\SqlToMigration\Queries\Constraints\NotNull;
use Highideas\SqlToMigration\Queries\Constraints\DefaultValue;
use Highideas\SqlToMigration\Queries\Constraints\AutoIncrement;

abstract class AbstractColumn implements ColumnInterface
{
    use NotNull;
    use DefaultValue;
    use AutoIncrement;

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
}
