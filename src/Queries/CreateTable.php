<?php

namespace Highideas\SqlToMigration\Queries;

use Highideas\SqlToMigration\Queries\Columns\ColumnFactory;

class CreateTable implements QueryInterface
{
    protected $query;
    protected $table;
    protected $statements;
    protected $rawStatements;

    public function __construct($query)
    {
        $this->query = $query;
        $this->run();
    }

    protected function run()
    {
        $this->defineTable();
        $this->defineStatements();
    }

    protected function defineTable()
    {
        $output_array = [];
        preg_match(
            "/(CREATE TABLE IF NOT EXISTS|CREATE TABLE)[\s|`|']+([0-9a-zA-Z-_]+)[\s|`|'|\(](.*)/i",
            $this->query,
            $output_array
        );
        if (empty($output_array)) {
            throw new InvalidQueryException($query, 'Invalid Table.');
        }
        $this->table = $output_array[2];
        $this->rawStatements = $output_array[3];
    }

    protected function defineStatements()
    {
        $this->statements = StatementFactory::instantiate($this->rawStatements);
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getQuery()
    {
        return $this->query;
    }
}
