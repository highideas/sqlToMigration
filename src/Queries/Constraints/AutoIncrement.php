<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

trait AutoIncrement {

    public function isAutoIncrement()
    {
        $auto_increment = strpos(strtolower($this->getRaw()), 'auto_increment') !== false;
        $autoincrement = strpos(strtolower($this->getRaw()), 'autoincrement') !== false;
        return $auto_increment || $autoincrement;
    }

}
