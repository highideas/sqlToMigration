<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

use Highideas\SqlToMigration\Queries\Columns\ColumnFactory;
use Highideas\SqlToMigration\Queries\Columns\ColumnInterface;
use Highideas\SqlToMigration\Queries\Constraints\PrimaryKey;
use Highideas\SqlToMigration\Queries\Validators\IntegrityValidator;
use Highideas\SqlToMigration\Collections\Collection;

class Statement
{
    protected $primaryKeyInstance;
    protected $columns = [];
    protected $columnDefinitions = [];
    protected $columnsQuantity = 0;

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
            $this->getPrimaryKeyInstance()->checkColumn($statement);
            return;
        }

        $column = ColumnFactory::instantiate($statement);
        $this->getCollectionInstance()->add($column->getName(), $column);
    }

    public function getCollectionInstance()
    {
        if (!$this->columns instanceof Collection) {
            $this->columns = new Collection();
        }
        return $this->columns;
    }

    public function getPrimaryKeyInstance()
    {
        if (!$this->primaryKeyInstance instanceof PrimaryKey) {
            $this->primaryKeyInstance = new PrimaryKey();
        }
        return $this->primaryKeyInstance;
    }

    public function isValid()
    {
        $validator = new IntegrityValidator($this->getPrimaryKeyInstance(), $this->getCollectionInstance());
        $validator->setColumnsQuantityExpected($this->columnsQuantity);
        return $validator->validate();
    }
}
