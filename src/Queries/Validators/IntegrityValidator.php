<?php

namespace Highideas\SqlToMigration\Queries\Validators;

use Highideas\SqlToMigration\Queries\Constraint\ConstraintInterface;

/**
 * @property ConstraintInterface $constraint
 * @property ColumnInterface[] $columns
 */
class IntegrityValidator implements ValidatorInterface
{

    private $constraint;
    private $columns;

    public function __construct(ConstraintInterface $constraint, Array $columns)
    {
        $this->constraint = $constraint;
        $this->columns = $columns;
    }

    public function constraintsIsInColumns()
    {
        $constraints = $this->constraint->getColumns();
        foreach ($this->columns as $column) {
            $key = array_search($column->getName(), $constraints);
            if ($key !== false) {
                unset($constraints[$key]);
            }
        }
        return empty($constraints);
    }

    public function validate()
    {
        return true;
    }
}
