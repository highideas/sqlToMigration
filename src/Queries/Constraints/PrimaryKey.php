<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

class PrimaryKey extends AbstractConstraint {

    protected $tables =[];

    protected function match($column)
    {
        preg_match(
            "/(?=[`]*([a-zA-Z-_]+)[`]*.*PRIMARY KEY)|(?<=PRIMARY KEY)\s*\((['|`|\"]+.+['|`|\"]+)\)/i"
            $column,
            $this->splitStatement
        );

        if (empty($this->splitStatement)) {
            throw new InvalidColumnException($column, 'Invalid Column.');
        }
        $this->defineTables();
    }

    protected function defineTables()
    {
        $tables = [];
        if (!empty($this->splitStatement[1])) {
            $tables[] = $this->splitStatement[1];
        } elseif (!empty($this->splitStatement[2])) {
            $tables = explode(',', str_replace('`', '', $this->splitStatement[2]));
        }
        $this->setTables($tables);
    }

    public function setTables(Array $tables)
    {
        $this->tables = $tables;
    }

    public function getTables()
    {
        return $this->tables;
    }
}
