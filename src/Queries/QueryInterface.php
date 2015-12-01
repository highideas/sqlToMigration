<?php

namespace Highideas\SqlToMigration\Queries;

interface QueryInterface
{
    public function getTable();
    public function getQuery();
    public function getColumns();
    public function getColumnInstance($column);

    protected function run();
    protected function defineTable();
    protected function defineColumns();
}
