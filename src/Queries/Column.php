<?php

namespace Highideas\SqlToMigration\Queries;

class Column
{
    protected $column;
    protected $type;

    public function __construct($query)
    {
        $output_array = [];
        preg_match("/^([a-zA-Z-_]+)\s+([\w\W]+)/i", $column, $output_array);
        if (empty($output_array)) {
            return $column;
        }
        $this->column = $output_array[1];
        $this->type = $output_array[2];
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getType()
    {
        return $this->type;
    }
}
