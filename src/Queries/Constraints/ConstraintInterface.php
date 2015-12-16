<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

interface ConstraintInterface {
    public function getRaw();
    public function setRaw($raw);
}
