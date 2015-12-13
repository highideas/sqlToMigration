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

    public function testWhenCharTypeGetSizeShouldReturnOne()
    {
        $char = new VarcharColumn('gender char');
        $this->assertEquals(1, $char->getSize());
    }

    public function testGetNameShouldReturnNameOfColumn()
    {
        $varchar = new VarcharColumn("name varchar default 'John Smith'");
        $this->assertEquals('name', $varchar->getName());
    }
}
