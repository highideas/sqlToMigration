<?php

namespace Highideas\SqlToMigration\Test\Queries;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\CreateTable;
use Highideas\SqlToMigration\Queries\QueryFactory;
use Highideas\SqlToMigration\Exceptions\InvalidQueryException;

class QueryFactoryTest extends PHPUnit_Framework_TestCase
{
    protected function validQuery()
    {
        return 'CREATE TABLE `PREFIX_roles` (' .
            '  `ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,' .
            '  `Description` text NOT NULL' .
            ');';
    }

    public function testInstantiateShouldReturnCreateTableObject()
    {
        $class = QueryFactory::instantiate('create', $this->validQuery());
        $this->assertInstanceOf(
            'Highideas\SqlToMigration\Queries\CreateTable',
            $class
        );
    }

    public function testInstantiateSShouldReturnInvalidQueryExceptionWhenInvalidParamPassed()
    {
        $query = "UPDATE PREFIX_roles SET `Description` = 'root'";
        try {
            $class = QueryFactory::instantiate('update', $query);
        } catch (\Highideas\SqlToMigration\Exceptions\InvalidQueryException $expected) {
            $this->assertEquals('Type of Query Not Found.', $expected->getMessage());
            $this->assertEquals('update', $expected->getName());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }
}
