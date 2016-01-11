<?php

namespace Highideas\SqlToMigration\Test\Queries\Statements\Columns;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Statements\Columns\ColumnFactory;

class ColumnFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testInstantiateShouldReturnVarcharColumnObject()
    {
        $class = ColumnFactory::instantiate('`Title` varchar(128) NOT NULL');
        $this->assertInstanceOf(
            'Highideas\SqlToMigration\Queries\Statements\Columns\VarcharColumn',
            $class
        );
    }

    public function testInstantiateShouldReturnIntegerColumnObject()
    {
        $class = ColumnFactory::instantiate('`Rght` INTEGER NOT NULL');
        $this->assertInstanceOf(
            'Highideas\SqlToMigration\Queries\Statements\Columns\IntegerColumn',
            $class
        );
    }

    public function testInstantiateShouldReturnTextColumnObject()
    {
        $class = ColumnFactory::instantiate('`Description` text NOT NULL');
        $this->assertInstanceOf(
            'Highideas\SqlToMigration\Queries\Statements\Columns\TextColumn',
            $class
        );
    }

    /**
     * @expectedException        Highideas\SqlToMigration\Exceptions\InvalidColumnException
     * @expectedExceptionMessage Column Not Found.
     */
    public function testInstantiateShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        ColumnFactory::instantiate('integer');
    }

    /**
     * @expectedException        Highideas\SqlToMigration\Exceptions\InvalidColumnException
     * @expectedExceptionMessage Column Not Found.
     */
    public function testInstantiateShouldReturnInvalidColumnExceptionWhenUnknownColumnInformed()
    {
        ColumnFactory::instantiate('`Active` boolean NOT NULL');
    }
}
