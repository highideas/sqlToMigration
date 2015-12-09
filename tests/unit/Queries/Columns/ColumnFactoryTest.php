<?php

namespace Highideas\SqlToMigration\Test\Queries\Columns;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Columns\ColumnFactory;

class ColumnFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testInstantiateShouldReturnVarcharColumnObject()
    {
        $class = ColumnFactory::instantiate('item_name character varying(64) NOT NULL');
        $this->assertInstanceOf(
            'Highideas\SqlToMigration\Queries\Columns\VarcharColumn',
            $class
        );
    }

    /**
     * @expectedException Highideas\SqlToMigration\Exceptions\InvalidColumnException
     */
    public function testInstantiateShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        ColumnFactory::instantiate('integer');
    }
}
