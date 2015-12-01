<?php

namespace Highideas\SqlToMigration\Queries;

use Highideas\SqlToMigration\Queries\Columns\ColumnFactory;

class CreateTable implements QueryInterface
{
    protected $query;
    protected $table;
    protected $columns = [];

    public function __construct($query)
    {
        $this->query = $query;
        $this->run();
    }

    protected function run()
    {
        $this->defineTable();
        $this->defineColumns();
    }

    protected function defineTable()
    {
        $output_array = [];
        preg_match(
            "/(CREATE TABLE IF NOT EXISTS|CREATE TABLE)[\s|`|']+([0-9a-zA-Z-_]+)[\s|`|'|\(]+/i",
            $this->query,
            $output_array
        );
        if (empty($output_array)) {
            throw new InvalidQueryException($query, 'Invalid Table.');
        }
        $this->table = $output_array[2];
    }

    protected function defineColumns()
    {
        $output_array = [];
        $query = rtrim(ltrim(str_replace(';', '', $this->query), '('), ')');
        preg_match_all(
            "/[^\(|^\,][^\,]+\S+[^\,|\s]/i",
            $query,
            $output_array
        );
        if (empty($output_array)) {
            throw new InvalidQueryException($query, 'Invalid Column.');
        }
        $columns = reset($output_array);
        foreach ($columns as $key => $column) {
            $this->columns[] = $this->getColumnInstance($column);
        }
    }

    public function getColumnInstance($column)
    {
        return ColumnFactory::instantiate($column);
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
