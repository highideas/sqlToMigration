<?php

namespace Highideas\SqlToMigration\Queries\Validators;

use Highideas\SqlToMigration\Queries\Constraint\ConstraintInterface;

class IntegrityValidator implements ValidatorInterface
{

    private $constraint;
    private $columns;

    public function __construct(ConstraintInterface $constraint, Array $columns)
    {
        $this->constraint = $constraint;
        $this->columns = $columns;
    }

    public function validate()
    {
        return true;
    }
}
