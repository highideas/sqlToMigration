<?php

namespace Highideas\SqlToMigration\Queries\Columns;

interface ColumnInterface
{
    public function getRaw();
    public function setRaw($raw);
    public function getName();
    public function getType();
}
