<?php

namespace Highideas\SqlToMigration\Test\Queries\Statements;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Statements\Statement;
use Highideas\SqlToMigration\Queries\Statements\Constraints\PrimaryKey;
use Highideas\SqlToMigration\Queries\Statements\Columns\IntegerColumn;
use Highideas\SqlToMigration\Queries\Statements\Columns\VarcharColumn;

class StatementTest extends PHPUnit_Framework_TestCase
{
    public function testGetPrimaryKeyInstanceShouldReturnPrimaryKeyInstance()
    {
        $statement = new Statement();
        $this->assertInstanceOf(
            '\Highideas\SqlToMigration\Queries\Statements\Constraints\PrimaryKey',
            $statement->getPrimaryKeyInstance()
        );
    }

    public function testLoadStatementShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        $statement = new Statement();
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

        $statement = new Statement();
        $statement->loadStatement('`Lft` INTEGER NOT NULL,');
        $statement->loadStatement('`Title` char(64) NOT NULL,');

        $this->assertEquals($int, $statement->getCollectionInstance()->get('Lft'));
        $this->assertEquals($char, $statement->getCollectionInstance()->get('Title'));
    }

    public function testLoadStatementShouldUpdatePrimaryKeyInstance()
    {
        $statement = new Statement();
        $statement->run(['PRIMARY KEY  (`RoleID`,`PermissionID`)']);
        $expected = ['RoleID' => 'RoleID','PermissionID' => 'PermissionID',];
        $this->assertEquals($expected, $statement->getPrimaryKeyInstance()->getColumns());
    }

    public function testRunShouldLoadStatements()
    {
        $int = new IntegerColumn('`Lft` INTEGER NOT NULL,');
        $char = new VarcharColumn('`Title` char(64) NOT NULL,');

        $statements = [
            '`Lft` INTEGER NOT NULL,',
            '`Title` char(64) NOT NULL,'
        ];

        $statement = new Statement();
        $statement->run($statements);

        $this->assertEquals($int, $statement->getCollectionInstance()->get('Lft'));
        $this->assertEquals($char, $statement->getCollectionInstance()->get('Title'));
    }

    public function testIsValidShouldReturnFalseWhenStatementInvalidInformed()
    {
        $statements = [
            '`Lft` INTEGER NOT NULL,',
            'invalid column,'
        ];

        $statement = new Statement();
        $statement->run($statements);
        $this->assertFalse($statement->isValid());
    }
}
