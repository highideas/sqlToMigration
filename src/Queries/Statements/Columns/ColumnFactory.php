<?php

namespace Highideas\SqlToMigration\Queries\Statements\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

class ColumnFactory
{
    protected static $characters = ['char', 'varchar', 'varying'];
    protected static $integers = ['int', 'integer', 'smallint', 'bigint'];
    protected static $texts = ['text'];

    public static function instantiate($column)
    {
        preg_match("/^[`]*[a-zA-Z-_]+[`]*\s+(\w*)/i", $column, $outputArray);

        if (!isset($outputArray[1]) || empty($outputArray[1])) {
            throw new InvalidColumnException($column, 'Column Not Found.');
        }

        $columnType = trim(strtolower($outputArray[1]));

        if (in_array($columnType, self::$characters)) {
            return new VarcharColumn($column);
        }

        if (in_array($columnType, self::$integers)) {
            return new IntegerColumn($column);
        }

        if (in_array($columnType, self::$texts)) {
            return new TextColumn($column);
        }
        throw new InvalidColumnException($column, 'Column Not Found.');
    }
}
