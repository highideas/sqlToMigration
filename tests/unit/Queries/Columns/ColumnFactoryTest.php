<?php

namespace Highideas\SqlToMigration\Test\Queries\Columns;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Columns\ColumnFactory;

class ColumnFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testInstantiateShouldReturnVarcharColumnObject()
    {
        $class = ColumnFactory::instantiate('`Title` varchar(128) NOT NULL');
        $this->assertInstanceOf(
            'Highideas\SqlToMigration\Queries\Columns\VarcharColumn',
            $class
        );
    }

    public function testInstantiateShouldReturnIntegerColumnObject()
    {
        $class = ColumnFactory::instantiate('`Rght` INTEGER NOT NULL');
        $this->assertInstanceOf(
            'Highideas\SqlToMigration\Queries\Columns\IntegerColumn',
            $class
        );
    }

    public function testInstantiateShouldReturnTextColumnObject()
    {
        $class = ColumnFactory::instantiate('`Description` text NOT NULL');
        $this->assertInstanceOf(
            'Highideas\SqlToMigration\Queries\Columns\TextColumn',
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
