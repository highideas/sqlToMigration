<?php

namespace Highideas\SqlToMigration\Queries\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

class IntegerColumn extends Column
{

    protected function match($column)
    {
        preg_match(
            "/^[`]*([a-zA-Z-_]+)[`]*\s+(INTEGER|INT|SMALLINT|BIGINT)\s*\(*([\d]*)\)*\s+\s*(NOT NULL|NULL|DEFAULT\s+[\d]+)*\s*(NOT NULL|NULL|DEFAULT\s+[\d]+)*/i",
            $column,
            $this->splitColumn
        );
        $this->setDefaultRegex("/^default\s+(\d+)/i");

        if (empty($this->splitColumn)) {
            throw new InvalidColumnException($column, 'Invalid Column.');
        }
    }

    protected function prepare()
    {
        parent::prepare();
        $this->defineDefaultSize();
        $this->size = (int)(empty($this->splitColumn[3]) ? $this->getDefaultSize() : $this->splitColumn[3]);
    }

    protected function defineDefaultSize()
    {
        $this->defaultSize = 11;
    }
}
