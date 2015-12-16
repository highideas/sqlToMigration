<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Queries\Columns\ColumnInterface;

trait Constraint {

    use NotNull;
    use DefaultValue;
}
