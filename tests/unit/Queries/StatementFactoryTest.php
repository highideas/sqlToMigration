<?php

namespace Highideas\SqlToMigration\Test\Queries;

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
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Queries\Statements\Statement',
            StatementFactory::instantiate($this->validQuery())
        );
    }

    public function testInstantiateShouldReturnStatementInstanceWhenInvalidQueryPassed()
    {
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Queries\Statements\Statement',
            StatementFactory::instantiate($this->invalidQuery())
        );
    }

    /**
     * @expectedException        Highideas\SqlToMigration\Exceptions\InvalidQueryException
     * @expectedExceptionMessage Invalid Query.
     */
    public function testInstantiateShouldGenerateInvalidQueryExceptionWhenEmptyStringInformed()
    {
        StatementFactory::instantiate('');
    }
}
