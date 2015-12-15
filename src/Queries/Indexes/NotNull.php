<?php

namespace Highideas\SqlToMigration\Queries\Indexes;

use Highideas\SqlToMigration\Queries\Columns\ColumnInterface;

trait NotNull {

    public function isNullable()
    {
        return strpos(strtolower($this->getRaw()), 'not null') === false;
    }

}
