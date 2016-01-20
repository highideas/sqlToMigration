<?php

namespace Highideas\SqlToMigration\Queries\Statements;

use Highideas\SqlToMigration\Collections\Collection;
use Highideas\SqlToMigration\Exceptions\InvalidQueryException;
use Highideas\SqlToMigration\Queries\Statements\Statement;
use Highideas\SqlToMigration\Queries\Statements\Constraints\PrimaryKey;
use Highideas\SqlToMigration\Queries\Validators\IntegrityValidator;

class StatementFactory
{

    public static function instantiate($query)
    {
        $outputArray = [];
        $query = trim(rtrim(ltrim(str_replace(';', '', $query), '('), ')'));
        preg_match_all(
            "/\s*([^\(|^\,][^\,]+\S+[^\,|\s])/i",
            $query,
            $outputArray
        );
        if (empty($outputArray[1])) {
            throw new InvalidQueryException($query, 'Invalid Query.');
        }
        $statements = $outputArray[1];
        $statement = new Statement(new Collection, new PrimaryKey, new IntegrityValidator);

        return $statement->run($statements);
    }
}
