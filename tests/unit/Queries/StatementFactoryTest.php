<?php

namespace Highideas\SqlToMigration\Test\Queries\Validators;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\StatementFactory;

class StatementFactoryTest extends PHPUnit_Framework_TestCase
{

    protected function query()
    {
        return '(            `ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,' .
            '            `Lft` INTEGER NOT NULL,' .
            '            `Rght` INTEGER NOT NULL,' .
            '            `Title` char(64) NOT NULL,' .
            '            `Description` text NOT NULL        );';
    }

    public function testInstantiateShouldReturnStatementInstance()
    {
        $statements = StatementFactory::instantiate($this->query());
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Queries\Constraints\Statement',
            $statements
        );
    }
}
