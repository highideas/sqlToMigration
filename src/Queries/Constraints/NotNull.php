<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

trait NotNull {

    public function isNullable()
    {
        return strpos(strtolower($this->getRaw()), 'not null') === false;
    }

}
