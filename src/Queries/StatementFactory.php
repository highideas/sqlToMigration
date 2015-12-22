<?php

namespace Highideas\SqlToMigration\Queries;


use Highideas\SqlToMigration\Exceptions\InvalidQueryException;

class StatementFactory
{

    public static function instantiate($query)
    {
        $output_array = [];
        $query = rtrim(ltrim(str_replace(';', '', $query), '('), ')');
        preg_match_all(
            "/[^\(|^\,][^\,]+\S+[^\,|\s]/i",
            $query,
            $output_array
        );
        if (empty($output_array)) {
            throw new InvalidQueryException($query, 'Invalid Query.');
        }
        $statements = reset($output_array);
        return $statement;
    }
}
