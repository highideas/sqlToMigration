<?php

namespace Highideas\SqlToMigration\Test\Queries\Constraints;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Constraints\StatementCollection;
use Highideas\SqlToMigration\Queries\Constraints\PrimaryKey;
use Highideas\SqlToMigration\Queries\Columns\IntegerColumn;
use Highideas\SqlToMigration\Queries\Columns\VarcharColumn;

class StatementCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testGetPrimaryKeyInstanceShouldReturnPrimaryKeyInstance()
    {
        $collection = new StatementCollection();
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Queries\Constraints\PrimaryKey',
            $collection->getPrimaryKeyInstance()
        );
    }

    public function testLoadStatementShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        $collection = new StatementCollection();
        try {
            $collection->loadStatement('Invalid column query');
        } catch (\Highideas\SqlToMigration\Exceptions\InvalidColumnException $expected) {
            $this->assertEquals('Statement Not Found.', $expected->getMessage());
            $this->assertEquals('Invalid column query', $expected->getName());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testLoadStatementShouldLoadColumns()
    {
        $int = new IntegerColumn('`Lft` INTEGER NOT NULL,');
        $char = new VarcharColumn('`Title` char(64) NOT NULL,');

        $collection = new StatementCollection();
        $collection->loadStatement('`Lft` INTEGER NOT NULL,');
        $collection->loadStatement('`Title` char(64) NOT NULL,');

        $this->assertEquals($int, $collection->getColumns()['Lft']);
        $this->assertEquals($char, $collection->getColumns()['Title']);
    }

    public function testLoadStatementShouldUpdatePrimaryKeyInstance()
    {
        $collection = new StatementCollection();
        $collection->loadStatement('PRIMARY KEY  (`RoleID`,`PermissionID`)');
        $expected = ['RoleID' => 'RoleID','PermissionID' => 'PermissionID',];
        $this->assertEquals($expected, $collection->getPrimaryKeyInstance()->getColumns());
    }

    public function testRunShouldLoadStatements()
    {
        $int = new IntegerColumn('`Lft` INTEGER NOT NULL,');
        $char = new VarcharColumn('`Title` char(64) NOT NULL,');

        $statements = [
            '`Lft` INTEGER NOT NULL,',
            '`Title` char(64) NOT NULL,'
        ];

        $collection = new StatementCollection();
        $collection->run($statements);

        $this->assertEquals($int, $collection->getColumns()['Lft']);
        $this->assertEquals($char, $collection->getColumns()['Title']);
    }
}
