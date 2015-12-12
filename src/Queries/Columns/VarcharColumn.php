<?php

namespace Highideas\SqlToMigration\Queries\Columns;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

class VarcharColumn extends AbstractColumn
{

    protected function match($column)
    {
        preg_match(
            "/^([a-zA-Z-_]+)\s+(CHARACTER|CHAR|CHARACTER VARYING|VARCHAR|NATIONAL CHARACTER|NCHAR|NATIONAL CHARACTER VARYING|NVARCHAR)\s*\(*([\d]*)\)*\s*(NOT NULL|NULL|DEFAULT\s[\W][\w]+[\W])*\s*(NOT NULL|NULL|DEFAULT\s[\W][\w]+[\W])*/i",
            $column,
            $this->splitColumn
        );
        if (empty($this->splitColumn))
            $this->setInvalidColumnException('Invalid Column.');
    }

    protected function prepare()
    {
        parent::prepare();
        $defaultParam = 256;
        if ($this->isCharacter()) {
            $defaultParam = 1;
        }
        $this->param = empty($this->splitColumn[3]) ? $defaultParam : $this->splitColumn[3];
    }

    protected function isCharacter()
    {
        return strpos(strtolower($this->type), 'var') === false;
    }

    protected function setDefault()
    {
        foreach ($this->splitColumn as $key => $value) {
            if (strpos(strtolower($value), 'default') !== false) {
                $this->default = preg_replace(
                    "/^default\s+[`|'|\"]{1}(.*)[`|'|\"]{1}/i",
                    "$1",
                    $value
                );
                break;
            }
        }
        if (empty($this->default))
            $this->setInvalidColumnException('Invalid Default Value.');
    }
}
