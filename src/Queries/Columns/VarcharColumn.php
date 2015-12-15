<?php

namespace Highideas\SqlToMigration\Queries\Columns;

class VarcharColumn extends AbstractColumn
{

    protected function match($column)
    {
        preg_match(
            "/^[`]*([a-zA-Z-_]+)[`]*\s+(CHARACTER|CHAR|CHARACTER VARYING|VARCHAR|NATIONAL CHARACTER|NCHAR|NATIONAL CHARACTER VARYING|NVARCHAR)\s*\(*([\d]*)\)*\s*(NOT NULL|NULL|DEFAULT\s[\W][\w]+[\W])*\s*(NOT NULL|NULL|DEFAULT\s[\W][\w]+[\W])*/i",
            $column,
            $this->splitColumn
        );
        $this->setDefaultRegex("/^default\s+[`|'|\"]{1}(.*)[`|'|\"]{1}/i");

        if (empty($this->splitColumn))
            $this->setInvalidColumnException('Invalid Column.');
    }

    protected function prepare()
    {
        parent::prepare();
        $this->defineDefaultSize();
        $this->size = (int)(empty($this->splitColumn[3]) ? $this->getDefaultSize() : $this->splitColumn[3]);
    }

    protected function defineDefaultSize()
    {
        $this->defaultSize = 256;
        if ($this->isCharacter()) {
            $this->defaultSize = 1;
        }
    }

    protected function isCharacter()
    {
        return strpos(strtolower($this->type), 'var') === false;
    }
}
