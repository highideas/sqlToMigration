<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

use Highideas\SqlToMigration\Queries\Columns\ColumnFactory;
use Highideas\SqlToMigration\Queries\Constraints\PrimaryKey;
use \SplObjectStorage;

class StatementCollection extends SplObjectStorage
{
    protected $primaryKeyInstance;
    protected $columns = [];
    protected $columnDefinitions = [];

    public function run(Array $statements)
    {
        foreach ($statements as $key => $column) {
            $this->getStatementInstance($column);
        }
        return $this;
    }

    public function getStatementInstance($column)
    {
        preg_match("/^[`]*[a-zA-Z-_]*[`]*\s*(CHAR|VARCHAR|TEXT|INTEGER|PRIMARY\sKEY)/i", $column, $output_array);

        if (!isset($output_array[1]) || empty($output_array[1])) {
            throw new InvalidColumnException($column, 'Statement Not Found.');
        }

        $statementType = trim(strtolower($output_array[1]));

        if ($statementType == 'primary key') {
            $this->getPrimaryKeyInstance()->addColumn($column);
        }

        try {
            $this->columns[] = ColumnFactory::instantiate($column);;
        } catch (InvalidColumnException $e) {
            print_r($e->getName());
        }
        return;
    }

    public function getPrimaryKeyInstance()
    {
        if (!$this->primaryKeyInstance instanceof PrimaryKey) {
            $this->primaryKeyInstance = new PrimaryKey();
        }
        return $this->primaryKeyInstance;
    }
}
