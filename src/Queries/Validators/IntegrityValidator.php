<?php

namespace Highideas\SqlToMigration\Queries\Validators;

use Highideas\SqlToMigration\Queries\Statements\Constraints\ConstraintInterface;
use Highideas\SqlToMigration\Collections\Collection;
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
        foreach ($this->statement->getPrimaryKeyInstance()->getColumns() as $constraint) {
            if (!$this->statement->getCollectionInstance()->exist($constraint)) {
                $this->addError($constraint, 'Constraint do not exist in columns list');
            }
        }
        return !$this->hasError();
    }

    public function columnsQuantityExpected()
    {
        if ($this->statement->getCollectionInstance()->count() != $this->statement->getColumnsQuantity()) {
            $this->addError(
                'invalidColumnsQuantityExpected',
                'Columns Quantity Expected: ' . $this->statement->getColumnsQuantity() .
                ' Columns Quantity Found: ' . $this->statement->getCollectionInstance()->count()
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
