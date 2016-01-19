<?php

namespace Highideas\SqlToMigration\Queries\Validators;

use Highideas\SqlToMigration\Queries\Statements\Statement;

/**
 * @property Statement $statement
 * @property Array $errors
 */
class IntegrityValidator implements ValidatorInterface
{

    private $statement;
    private $errors;

    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

    public function constraintsIsInColumns()
    {
        foreach ($this->statement->getPrimaryKey()->getColumns() as $constraint) {
            if (!$this->statement->getCollection()->exist($constraint)) {
                $this->addError($constraint, 'Constraint do not exist in columns list');
            }
        }
        return !$this->hasError();
    }

    public function columnsQuantityExpected()
    {
        if ($this->statement->getCollection()->count() != $this->statement->getColumnsQuantity()) {
            $this->addError(
                'invalidColumnsQuantityExpected',
                'Columns Quantity Expected: ' . $this->statement->getColumnsQuantity() .
                ' Columns Quantity Found: ' . $this->statement->getCollection()->count()
            );
        }
        return;
    }

    public function hasError()
    {
        return !empty($this->getErrors());
    }

    public function addError($attribute, $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function validate()
    {
        $this->constraintsIsInColumns();
        $this->columnsQuantityExpected();
        return empty($this->getErrors());
    }
}
