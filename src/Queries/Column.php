<?php

namespace Highideas\SqlToMigration\Queries;

class Column
{
    protected $column;
    protected $type;
    protected $raw;

    public function __construct($column)
    {
        $output_array = [];
        preg_match("/^([a-zA-Z-_]+)\s+([\w\W]+)/i", $column, $output_array);
        if (empty($output_array)) {
            throw new InvalidQueryException($column, 'Invalid Column.');
        }
        $this->column = $output_array[1];
        $this->type = $output_array[2];
        $this->raw = $column;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isNullable()
    {
        return strpos(strtolower($this->raw), 'not null') === false;
    }
}
