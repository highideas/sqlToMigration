<?php

namespace Highideas\SqlToMigration\Queries\Indexes;

trait NotNull {

    public function isNullable()
    {
        return strpos(strtolower($this->getRaw()), 'not null') === false;
    }

}
