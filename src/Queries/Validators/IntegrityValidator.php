<?php

namespace Highideas\SqlToMigration\Queries\Validators;

use Highideas\SqlToMigration\Queries\Constraint\ConstraintInterface;
use Highideas\SqlToMigration\Collections\Collection;

/**
 * @property ConstraintInterface $constraint
 * @property Collection $columns
 */
class IntegrityValidator implements ValidatorInterface
{

    private $constraint;
    private $columns;
    private $errors;

    public function __construct(ConstraintInterface $constraint, Collection $columns)
    {
        $this->constraint = $constraint;
        $this->columns = $columns;
    }

    public function constraintsIsInColumns()
    {
        foreach ($this->constraint->getColumns() as $constraint) {
            if (!$this->columns->exist($constraint)) {
                $this->addError($constraint, 'Constraint do not exist in columns list');
            }
        }
        return !$this->hasError();
    }

    public function hasError()
    {
        return !empty($this->errors);
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
        return true;
    }
}
