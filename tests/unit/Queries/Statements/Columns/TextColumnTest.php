<?php

namespace Highideas\SqlToMigration\Test\Queries\Statements\Columns;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Statements\Columns\TextColumn;

class TextColumnTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException        Highideas\SqlToMigration\Exceptions\InvalidColumnException
     * @expectedExceptionMessage Invalid Column.
     */
    public function testNewInstanceOfTextColumnShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        new TextColumn('integer');
    }

    public function testGetSizeShouldReturnSize()
    {
        $text = new TextColumn('`Description` text NOT NULL');
        $this->assertEquals(0, $text->getSize());
    }

    public function testGetTypeShouldReturnTypeOfColumn()
    {
        $text = new TextColumn('`Description` text NOT NULL');
        $this->assertEquals('text', $text->getType());
    }

    public function testGetDefaultShouldReturnNull()
    {
        $text = new TextColumn('`Description` text NOT NULL');
        $this->assertNull($text->getDefault());

        $stub = $this->getMockBuilder('Highideas\SqlToMigration\Queries\Statements\Columns\TextColumn')
            ->setMethods(['__construct'])
            ->setConstructorArgs(['`Description` text NOT NULL'])
            ->disableOriginalConstructor()
            ->getMock();

        $stub->method('hasDefault')
             ->willReturn(true);

        $this->assertNull($stub->getDefault());
    }
}
