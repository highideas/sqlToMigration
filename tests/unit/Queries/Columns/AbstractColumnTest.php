<?php

namespace Highideas\SqlToMigration\Test\Queries\Columns;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Columns\AbstractColumn;

class AbstractColumnTest extends PHPUnit_Framework_TestCase
{

    protected $classname = 'Highideas\SqlToMigration\Queries\Columns\AbstractColumn';

    public function testIsNullableShouldReturnTrueWhenNotInformed()
    {
        $stub = $this->getMockForAbstractClass(
            $this->classname,
            ['age integer default 0']
        );

        $this->assertTrue($stub->isNullable());
    }

    public function testIsNullableShouldReturnFalseWhenColumnIsNotNull()
    {
        $stub = $this->getMockForAbstractClass(
            $this->classname,
            ['name varchar NOT null']
        );
        $this->assertFalse($stub->isNullable());
    }
}
