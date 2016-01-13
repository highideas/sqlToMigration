<?php

namespace Highideas\SqlToMigration\Queries\Statements\Constraints;

interface ConstraintInterface
{
    public function getRaw();
    public function setRaw($raw);
    public function getColumns();
}
