<?php

namespace Highideas\SqlToMigration\Queries\Statements;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

use Highideas\SqlToMigration\Collections\Collection;
use Highideas\SqlToMigration\Queries\Statements\Columns\ColumnFactory;
use Highideas\SqlToMigration\Queries\Statements\Constraints\PrimaryKey;
use Highideas\SqlToMigration\Queries\Validators\IntegrityValidator;

class Statement
{
    protected $primaryKey;
    protected $columns;
    protected $columnsQuantity = 0;

    public function __construct(Collection $columns, PrimaryKey $primaryKey)
    {
        $this->primaryKey = $primaryKey;
        $this->columns = $columns;
    }

    public function run(Array $statements)
    {
        foreach ($statements as $column) {
            try {
                $this->loadStatement($column);
            } catch (InvalidColumnException $e) {
                $e->getName();
            }
        }
        return $this;
    }

    public function loadStatement($statement)
    {
        preg_match("/^[`]*[a-zA-Z-_]*[`]*\s*(CHAR|VARCHAR|TEXT|INTEGER|PRIMARY\sKEY)/i", $statement, $outputArray);

        $this->columnsQuantity++;
        if (!isset($outputArray[1]) || empty($outputArray[1])) {
            throw new InvalidColumnException($statement, 'Statement Not Found.');
        }

        if (strpos(trim(strtolower($statement)), 'primary key') !== false) {
            $this->getPrimaryKey()->checkColumn($statement);
        }

        $column = ColumnFactory::instantiate($statement);
        $this->getCollection()->add($column->getName(), $column);
    }

    /**
     * @return Collection Collection Instance
     */
    public function getCollection()
    {
        return $this->columns;
    }

    /**
     * @return PrimaryKey PrimaryKey Instance
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getColumnsQuantity()
    {
        return $this->columnsQuantity;
    }

    public function isValid()
    {
        $validator = new IntegrityValidator($this);
        return $validator->validate();
    }
}
