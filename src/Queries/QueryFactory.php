<?php

namespace Highideas\SqlToMigration\Queries;

use Highideas\SqlToMigration\Queries\CreateTable;

use Highideas\SqlToMigration\Exceptions\InvalidQueryException;

class QueryFactory
{
    /**
     * @param string $query
     */
    public static function instantiate($query)
    {

        switch ($query) {
            case 'create':
                return new CreateTable($query);
                break;

            default:
                throw new InvalidQueryException($query, 'Query Not Found.');
                break;
        }
    }
}
