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
}
