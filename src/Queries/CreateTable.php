<?php

namespace Highideas\SqlToMigration\Queries;

class CreateTable implements QueryInterface
{
    protected $query;
    protected $table;
    protected $colums = [];

    public function __construct($query)
    {
        $this->query = $query;
        $this->run();
    }

    protected function run()
    {
        $output_array = [];
        preg_match("/(CREATE TABLE IF NOT EXISTS|CREATE TABLE)\s?[`|']?([0-9a-zA-Z-_]+)[`|']?/i", $this->query, $output_array);
        $this->table = $output_array[2];
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getColumns()
    {
        return $this->colums;
    }

    public function getQuery()
    {
        return $this->query;
    }
}
