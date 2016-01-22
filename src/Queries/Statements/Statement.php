<?php

namespace Highideas\SqlToMigration\Queries\Statements;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

use Highideas\SqlToMigration\Collections\Collection;
use Highideas\SqlToMigration\Queries\Statements\Columns\ColumnFactory;
use Highideas\SqlToMigration\Queries\Statements\Constraints\PrimaryKey;
use Highideas\SqlToMigration\Queries\Validators\ValidatorInterface;

class Statement
{
    protected $primaryKey;
    protected $columns;
    protected $columnsQuantity = 0;
    protected $validator;

    public function __construct(Collection $columns, PrimaryKey $primaryKey, ValidatorInterface $validator)
    {
        $this->primaryKey = $primaryKey;
        $this->columns = $columns;
        $this->validator = $validator;
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

        $this->countColumn($statement);
        if (!isset($outputArray[1]) || empty($outputArray[1])) {
            throw new InvalidColumnException($statement, 'Statement Not Found.');
        }

        if (strpos(trim(strtolower($statement)), 'primary key') !== false) {
            $this->getPrimaryKey()->checkColumn($statement);
        }

        $column = ColumnFactory::instantiate($statement);
        $this->getCollection()->add($column->getName(), $column);
    }

    protected function countColumn($statement)
    {
        $isPrimaryKey = (strpos(trim(strtolower($statement)), 'primary key') !== false);
        $isJustConstraint = (strpos(trim(strtolower($statement)), '(') !== false);
        if ($isPrimaryKey && $isJustConstraint) {
            return;
        }
        $this->columnsQuantity++;
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
        $this->validator->setStatement($this);
        return $this->validator->validate();
    }

    public function getValidator()
    {
        return $this->validator;
    }
}
