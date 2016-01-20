<?php

namespace Highideas\SqlToMigration\Queries;

use Highideas\SqlToMigration\Queries\CreateTable;
use Highideas\SqlToMigration\Exceptions\InvalidQueryException;

class QueryFactory
{
    /**
     * @param string $type
     */
    public static function instantiate($type, $rawQuery)
    {

        switch ($type) {
            case 'create':
                return new CreateTable($rawQuery);
                break;

            default:
                throw new InvalidQueryException($type, 'Type of Query Not Found.');
                break;
        }
    }
}
