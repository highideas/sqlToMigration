<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

class PrimaryKey extends AbstractConstraint {

    protected $columns =[];

    protected function match()
    {
        preg_match(
            "/(?=[`]*([a-zA-Z-_]+)[`]*.*PRIMARY KEY)|(?<=PRIMARY KEY)\s*\((['|`|\"]+.+['|`|\"]+)\)/i",
            $this->getRaw(),
            $this->splitStatement
        );

        if (empty($this->splitStatement)) {
            throw new InvalidColumnException($this->getRaw(), 'Invalid Column.');
        }
        $this->defineColumns();
    }

    protected function defineColumns()
    {
        $columns = [];
        if (!empty($this->splitStatement[1])) {
            $columns[] = $this->splitStatement[1];
        } elseif (!empty($this->splitStatement[2])) {
            $columns = explode(',', str_replace('`', '', $this->splitStatement[2]));
        }
        $this->setColumns($columns);
    }

    public function setColumns(Array $columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
