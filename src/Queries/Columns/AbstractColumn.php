<?php

namespace Highideas\SqlToMigration\Queries\Columns;

abstract class AbstractColumn
{
    protected $column;
    protected $type;
    protected $raw;
    protected $param = '';
    protected $default = '';
    protected $splitColumn = [];

    abstract protected function setDefault();
    abstract protected function prepare();

    public function __construct($column)
    {
        $output_array = [];
        preg_match("/^([a-zA-Z-_]+)\s+([\w\W]+)/i", $column, $output_array);
        if (empty($output_array)) {
            throw new InvalidColumnException($column, 'Invalid Column.');
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

    public function getParam()
    {
        return $this->param;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function isNullable()
    {
        return strpos(strtolower($this->raw), 'not null') === false;
    }

    public function hasDefault()
    {
        return strpos(strtolower($this->raw), 'default') !== false;
    }
}
