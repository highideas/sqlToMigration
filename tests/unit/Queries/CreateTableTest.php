<?php

namespace Highideas\SqlToMigration\Test\Queries;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\CreateTable;
use Highideas\SqlToMigration\Exceptions\InvalidQueryException;
use Highideas\SqlToMigration\Exceptions\InvalidColumnException;
use Highideas\SqlToMigration\Collections\Collection;

class CreateTableTest extends PHPUnit_Framework_TestCase
{
    protected function validQuery()
    {
        return 'CREATE TABLE `PREFIX_roles` (' .
            '  `ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,' .
            '  `Lft` INTEGER NOT NULL,' .
            '  `Rght` INTEGER NOT NULL,' .
            '  `Title` varchar(128) NOT NULL,' .
            '  `Description` text NOT NULL' .
            ');';
    }

    public function testCreateTableShouldReturnInvalidQueryExceptionWhenInvalidParamPassed()
    {
        $query = 'CREATE TABLE PREFIX_roles';
        try {
            $table = new CreateTable($query);
        } catch (\Highideas\SqlToMigration\Exceptions\InvalidQueryException $expected) {
            $this->assertEquals('Invalid Table.', $expected->getMessage());
            $this->assertEquals($query, $expected->getName());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testCreateTableShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        $query = 'CREATE TABLE `PREFIX_roles`;';
        try {
            $table = new CreateTable($query);
        } catch (\Highideas\SqlToMigration\Exceptions\InvalidQueryException $expected) {
            $this->assertEquals('Invalid Query.', $expected->getMessage());
            $this->assertEquals('', $expected->getName());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testGetTableShouldReturnTableName()
    {
        $query = $this->validQuery();
        $table = new CreateTable($query);
        $this->assertEquals('PREFIX_roles', $table->getTable());
    }

    public function testGetColumsShouldReturnCollectionInstance()
    {
        $query = $this->validQuery();
        $table = new CreateTable($query);
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Collections\Collection',
            $table->getColumns()
        );
    }

    public function testGetStatementShouldReturnStatementInstance()
    {
        $query = $this->validQuery();
        $table = new CreateTable($query);
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Queries\Statements\Statement',
            $table->getStatement()
        );
    }

    public function testGetQueryShouldReturnRawQuery()
    {
        $query = $this->validQuery();
        $table = new CreateTable($query);
        $this->assertEquals(
            $query,
            $table->getQuery()
        );
    }
}
