<?php

namespace Highideas\SqlToMigration\Queries\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

class IntegerColumn extends AbstractColumn
{

    protected function match($column)
    {
        preg_match(
            "/^[`]*([a-zA-Z-_]+)[`]*\s+(INTEGER|INT|SMALLINT|BIGINT)\s*\(*([\d]*)\)*\s+\s*(NOT NULL|NULL|DEFAULT\s+[\d]+)*\s*(NOT NULL|NULL|DEFAULT\s+[\d]+)*/i",
            $column,
            $this->splitColumn
        );
        if (empty($this->splitColumn))
            throw new InvalidColumnException($column, 'Invalid Column.');
    }

    protected function prepare()
    {
        parent::prepare();
        $this->defineDefaultSize();
        $this->size = (int)(empty($this->splitColumn[3]) ? $this->getDefaultSize() : $this->splitColumn[3]);
    }

    protected function defineDefaultSize()
    {
        $this->defaultSize = 11;
    }

    protected function defineDefault()
    {
        foreach ($this->splitColumn as $key => $value) {
            if (strpos(strtolower($value), 'default') !== false) {
                $this->default = (int) preg_replace(
                    "/^default\s+(\d+)/i",
                    "$1",
                    $value
                );
                break;
            }
        }

        if (empty($this->default) || !is_int($this->default))
            $this->setInvalidColumnException('Invalid Default Value.');
    }
}
