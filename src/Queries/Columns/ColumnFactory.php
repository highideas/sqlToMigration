<?php

namespace Highideas\SqlToMigration\Queries\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

class ColumnFactory
{
    public static function instantiate($column)
    {
        $preFormatedColumn = trim(strtolower($column));
        if (strpos($preFormatedColumn, 'varying') !== false || strpos($preFormatedColumn, 'varchar')) {
            return new VarcharColumn($column);
        }
        throw new InvalidColumnException($column, 'Column Not Found.');
    }
}
