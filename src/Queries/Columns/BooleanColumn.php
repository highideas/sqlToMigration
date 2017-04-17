<?php

namespace Highideas\SqlToMigration\Queries\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

class BooleanColumn extends AbstractColumn
{

    protected function match($column)
    {
        preg_match(
            "/^[`]*([a-zA-Z-_]+)[`]*\s+(BOOLEAN)\s*(NOT NULL|NULL|)*/i",
            $column,
            $this->splitColumn
        );
        if (empty($this->splitColumn)) {
            $this->setInvalidColumnException('Invalid Column.');
        }
    }

    protected function defineDefault()
    {
    }
}
