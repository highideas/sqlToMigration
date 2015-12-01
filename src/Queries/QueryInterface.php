<?php

namespace Highideas\SqlToMigration\Queries;

interface QueryInterface
{
    protected function run();
    public function getTable();
    public function getColumns();
    public function getQuery()
}
