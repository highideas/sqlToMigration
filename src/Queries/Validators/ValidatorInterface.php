<?php

namespace Highideas\SqlToMigration\Queries\validators;

use Highideas\SqlToMigration\Queries\Statements\Statement;

interface ValidatorInterface
{
    public function validate();
    public function getErrors();
    public function addError($attribute, $message);
    public function hasError();
    public function setStatement(Statement $statement);
}
