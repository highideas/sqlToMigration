<?php

namespace Highideas\SqlToMigration\Queries;

use Highideas\SqlToMigration\Exceptions\InvalidQueryException;
use Highideas\SqlToMigration\Queries\Statements\Statement;

class StatementFactory
{

    public static function instantiate($query)
    {
        $output_array = [];
        $query = rtrim(ltrim(str_replace(';', '', $query), '('), ')');
        preg_match_all(
            "/\s*([^\(|^\,][^\,]+\S+[^\,|\s])/i",
            $query,
            $output_array
        );
        if (empty($output_array)) {
            throw new InvalidQueryException($query, 'Invalid Query.');
        }
        $statements = $output_array[1];
        $statement = new Statement();

        return $statement->run($statements);
    }
}
