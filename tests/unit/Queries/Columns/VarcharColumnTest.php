<?php

namespace Highideas\SqlToMigration\Test\Queries\Columns;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Columns\VarcharColumn;

class VarcharColumnTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException        Highideas\SqlToMigration\Exceptions\InvalidColumnException
     * @expectedExceptionMessage Invalid Column.
     */
    public function testNewInstanceOfVarcharColumnShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        new VarcharColumn('integer');
    }

    public function testWhenCharTypeGetParamShouldReturnOne()
    {
        $char = new VarcharColumn('gender char');
        $this->assertEquals(1, $char->getParam());
    }

    public function testIsNullableShouldReturnTrueWhenNotInformed()
    {
        $char = new VarcharColumn('name varchar default "test"');
        $this->assertTrue($char->isNullable());
    }

    public function testIsNullableShouldReturnFalseWhenColumnIsNotNull()
    {
        $char = new VarcharColumn('name varchar NOT null');
        $this->assertFalse($char->isNullable());
    }
}
