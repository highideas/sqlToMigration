<?php

namespace Highideas\SqlToMigration\Queries\validators;

interface ValidatorInterface
{
    public function validate();
    public function getErrors();
    public function addError($attribute, $message);
    public function hasError();
}
