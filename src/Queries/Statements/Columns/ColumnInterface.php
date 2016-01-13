<?php

namespace Highideas\SqlToMigration\Queries\Statements\Columns;

interface ColumnInterface
{
    public function getRaw();
    public function setRaw($raw);
    public function getName();
    public function getType();
}
