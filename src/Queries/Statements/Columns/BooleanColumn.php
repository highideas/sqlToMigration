<?php

namespace Highideas\SqlToMigration\Queries\Statements\Columns;

class BooleanColumn extends Column
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
