<?php

namespace Highideas\SqlToMigration\Test\Queries\Columns;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Columns\Column;

class ColumnTest extends PHPUnit_Framework_TestCase
{

    protected $classname = 'Highideas\SqlToMigration\Queries\Columns\Column';

    public function testIsNullableShouldReturnTrueWhenNotInformed()
    {
        $stub = $this->getMockForAbstractClass(
            $this->classname,
            ['age integer']
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

    public function testIsAutoIncrementShouldReturnFalseWhenColumnIsNotAutoIncrement()
    {
        $stub = $this->getMockForAbstractClass(
            $this->classname,
            ['year int NOT null']
        );
        $this->assertFalse($stub->isAutoIncrement());
    }

    public function testIsAutoIncrementShouldReturnTrueWhenColumnIsAutoIncrement()
    {
        $stub = $this->getMockForAbstractClass(
            $this->classname,
            ['year int NOT null auto_increment']
        );
        $this->assertTrue($stub->isAutoIncrement());

        $stub = $this->getMockForAbstractClass(
            $this->classname,
            ['year int NOT null AUTOINCREMENT']
        );
        $this->assertTrue($stub->isAutoIncrement());
    }
}
