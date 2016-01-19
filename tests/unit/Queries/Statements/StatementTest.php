<?php

namespace Highideas\SqlToMigration\Test\Queries\Statements;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Collections\Collection;
use Highideas\SqlToMigration\Queries\Statements\Statement;
use Highideas\SqlToMigration\Queries\Statements\Constraints\PrimaryKey;
use Highideas\SqlToMigration\Queries\Statements\Columns\IntegerColumn;
use Highideas\SqlToMigration\Queries\Statements\Columns\VarcharColumn;

class StatementTest extends PHPUnit_Framework_TestCase
{
    public function testGetPrimaryKeyInstanceShouldReturnPrimaryKeyInstance()
    {
        $statement = new Statement(new Collection(), new PrimaryKey());
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Queries\Statements\Constraints\PrimaryKey',
            $statement->getPrimaryKey()
        );
    }

    public function testLoadStatementShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        $statement = new Statement(new Collection(), new PrimaryKey());
        try {
            $statement->loadStatement('Invalid column query');
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

        $statement = new Statement(new Collection(), new PrimaryKey());
        $statement->loadStatement('`Lft` INTEGER NOT NULL,');
        $statement->loadStatement('`Title` char(64) NOT NULL,');

        $this->assertEquals($int, $statement->getCollection()->get('Lft'));
        $this->assertEquals($char, $statement->getCollection()->get('Title'));
    }

    public function testLoadStatementShouldUpdatePrimaryKeyInstance()
    {
        $statement = new Statement(new Collection(), new PrimaryKey());
        $statement->run(['PRIMARY KEY  (`RoleID`,`PermissionID`)']);
        $expected = ['RoleID' => 'RoleID','PermissionID' => 'PermissionID',];
        $this->assertEquals($expected, $statement->getPrimaryKey()->getColumns());
    }

    public function testRunShouldLoadStatements()
    {
        $int = new IntegerColumn('`Lft` INTEGER NOT NULL,');
        $char = new VarcharColumn('`Title` char(64) NOT NULL,');

        $statements = [
            '`Lft` INTEGER NOT NULL,',
            '`Title` char(64) NOT NULL,'
        ];

        $statement = new Statement(new Collection(), new PrimaryKey());
        $statement->run($statements);

        $this->assertEquals($int, $statement->getCollection()->get('Lft'));
        $this->assertEquals($char, $statement->getCollection()->get('Title'));
    }

    public function testIsValidShouldReturnFalseWhenStatementInvalidInformed()
    {
        $statements = [
            '`Lft` INTEGER NOT NULL,',
            'invalid column,'
        ];

        $statement = new Statement(new Collection(), new PrimaryKey());
        $statement->run($statements);
        $this->assertFalse($statement->isValid());
    }
}
