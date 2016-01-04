<?php

namespace Highideas\SqlToMigration\Test\Collections;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Collections\Collection;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public function testAddShouldSetKeyAndValueIntoArray()
    {
        $collection = new Collection();
        $collection->add('A', 1);
        $collection->add(2, 'B');
        $this->assertEquals(
            ['A' => 1, 2 => 'B'],
            $collection->getAll()
        );
    }

    public function testGetShouldReturnItemByKey()
    {
        $collection = new Collection();
        $collection->add('A', 1);
        $collection->add(2, 'B');
        $this->assertEquals(
            'B',
            $collection->get(2)
        );
        $this->assertEquals(
            1,
            $collection->get('A')
        );
    }

    public function testExistShouldReturnFalseIfKeyDoNotExist()
    {
        $collection = new Collection();
        $collection->add('A', 1);
        $collection->add(2, 'B');
        $this->assertFalse($collection->exist(3));
        $this->assertFalse($collection->exist('C'));
    }

    public function testExistShouldReturnTrueIfKeyExist()
    {
        $collection = new Collection();
        $collection->add('A', 1);
        $collection->add(2, 'B');
        $this->assertTrue($collection->exist(2));
        $this->assertTrue($collection->exist('A'));
    }
}
