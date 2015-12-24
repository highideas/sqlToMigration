<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

use Highideas\SqlToMigration\Queries\Columns\ColumnFactory;
use Highideas\SqlToMigration\Queries\Columns\ColumnInterface;
use Highideas\SqlToMigration\Queries\Constraints\PrimaryKey;

class StatementCollection
{
    protected $primaryKeyInstance;
    protected $columns = [];
    protected $columnDefinitions = [];

    public function run(Array $statements)
    {
        foreach ($statements as $column) {
            $this->loadStatement($column);
        }
        return $this;
    }

    public function loadStatement($statement)
    {
        preg_match("/^[`]*[a-zA-Z-_]*[`]*\s*(CHAR|VARCHAR|TEXT|INTEGER|PRIMARY\sKEY)/i", $statement, $outputArray);

        if (!isset($outputArray[1]) || empty($outputArray[1])) {
            throw new InvalidColumnException($statement, 'Statement Not Found.');
        }

        $statementType = trim(strtolower($outputArray[1]));

        if ($statementType == 'primary key') {
            $this->getPrimaryKeyInstance()->checkColumn($statement);
            return;
        }

        $column = ColumnFactory::instantiate($statement);
        $this->setColumns($column);
    }

    public function getPrimaryKeyInstance()
    {
        if (!$this->primaryKeyInstance instanceof PrimaryKey) {
            $this->primaryKeyInstance = new PrimaryKey();
        }
        return $this->primaryKeyInstance;
    }

    public function setColumns(ColumnInterface $column)
    {
        $this->columns[$column->getName()] = $column;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
