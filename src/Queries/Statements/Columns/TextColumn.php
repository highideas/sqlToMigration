<?php

namespace Highideas\SqlToMigration\Queries\Statements\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

class TextColumn extends Column
{

    protected function match($column)
    {
        preg_match(
            "/^[`]*([a-zA-Z-_]+)[`]*\s+(TEXT)\s*(NOT NULL|NULL)*/i",
            $column,
            $this->splitColumn
        );
        if (empty($this->splitColumn)) {
            throw new InvalidColumnException($this->getRaw(), 'Invalid Column.');
        }
    }
}
