<?php

namespace Highideas\SqlToMigration\Test\Queries\Validators;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\StatementFactory;

class StatementFactoryTest extends PHPUnit_Framework_TestCase
{

    protected function validQuery()
    {
        return '(            `ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,' .
            '            `Lft` INTEGER NOT NULL,' .
            '            `Rght` INTEGER NOT NULL,' .
            '            `Title` char(64) NOT NULL,' .
            '            `Description` text NOT NULL        );';
    }

    protected function invalidQuery()
    {
        return '(            `ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,' .
            '            `Lft` INTEGER NOT NULL,' .
            '            `Rght` INTEGER NOT NULL,' .
            '            `Title` char(64) NOT NULL,' .
            '            invalid statement,' .
            '            `Description` text NOT NULL        );';
    }

    public function testInstantiateShouldReturnStatementInstanceWhenValidQueryPassed()
    {
        $statements = StatementFactory::instantiate($this->validQuery());
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Queries\Statements\Statement',
            $statements
        );
    }

    public function testInstantiateShouldReturnStatementInstanceWhenInvalidQueryPassed()
    {
        $statements = StatementFactory::instantiate($this->invalidQuery());
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Queries\Statements\Statement',
            $statements
        );
    }
}
