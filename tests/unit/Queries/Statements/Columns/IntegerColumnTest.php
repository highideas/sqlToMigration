<?php

namespace Highideas\SqlToMigration\Test\Queries\Statements\Columns;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Statements\Columns\IntegerColumn;

class IntegerColumnTest extends PHPUnit_Framework_TestCase
{
    public function testNewInstanceOfIntegerColumnShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        try {
            new IntegerColumn('Invalid column query');
        } catch (\Highideas\SqlToMigration\Exceptions\InvalidColumnException $expected) {
            $this->assertEquals('Invalid column query', $expected->getName());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testGetDefaultShouldReturnIntegerValue()
    {
        $int = new IntegerColumn('year int default 2015');
        $this->assertEquals(2015, $int->getDefault());
    }

    /**
     * @expectedException        Highideas\SqlToMigration\Exceptions\InvalidColumnException
     * @expectedExceptionMessage Invalid Default Value.
     */
    public function testNewInstanceOfVarcharColumnShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        new IntegerColumn('year int default A');
    }

    public function testGetNameShouldReturnNameOfName()
    {
        $int = new IntegerColumn('year int default 2015');
        $this->assertEquals('year', $int->getName());
    }

    public function testGetSizeShouldReturnSize()
    {
        $int = new IntegerColumn('`Lft` int(11) NOT NULL');
        $this->assertEquals(11, $int->getSize());
    }

    public function testGetTypeShouldReturnTypeOfColumn()
    {
        $int = new IntegerColumn('`Rght` int(11) NOT NULL');
        $this->assertEquals('int', $int->getType());
    }
}
