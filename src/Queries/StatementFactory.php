<?php

namespace Highideas\SqlToMigration\Queries;

use Highideas\SqlToMigration\Queries\Columns\ColumnInterface;
use Highideas\SqlToMigration\Queries\Columns\ColumnFactory;
use Highideas\SqlToMigration\Queries\Constraints\ConstraintInterface;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

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
        $column = [];
        $columnDefinition = [];
        foreach ($statements as $key => $column) {
            $statement = self::getStatementInstance($column);
            if ($statement instanceOf ColumnInterface) {
                $column[] = $statement;
            }
            if ($statement instanceOf ConstraintInterface) {
                $columnDefinition[] = $statement;
            }
        }
    }

    public static function getStatementInstance($column)
    {
        preg_match("/^[`]*[a-zA-Z-_]*[`]*\s*(CHAR|VARCHAR|TEXT|INTEGER|PRIMARY\sKEY)/i", $column, $output_array);

        if (!isset($output_array[1]) || empty($output_array[1])) {
            throw new InvalidColumnException($column, 'Statement Not Found.');
        }

        $statementType = trim(strtolower($output_array[1]));

        if ($statementType == 'primary key') {
            return;
        }

        return ColumnFactory::instantiate($column);
    }
}
