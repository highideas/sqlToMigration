<?php

namespace Highideas\SqlToMigration\Test\Queries\Validators;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Collections\Collection;
use Highideas\SqlToMigration\Queries\Validators\IntegrityValidator;
use Highideas\SqlToMigration\Queries\Columns\ColumnFactory;
use Highideas\SqlToMigration\Queries\Constraints\PrimaryKey;

class IntegrityValidatorTest extends PHPUnit_Framework_TestCase
{

    protected $validStatement = '`ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,';
    protected $invalidStatement = '`NAME` VARCHAR,';

    protected function createValidPrimaryKey()
    {
        $primaryKey = new PrimaryKey();
        $primaryKey->checkColumn($this->validStatement);
        return $primaryKey;
    }

    protected function createValidColumn()
    {
        return ColumnFactory::instantiate($this->validStatement);
    }

    protected function createInvalidColumn()
    {
        return ColumnFactory::instantiate($this->invalidStatement);
    }

    protected function createValidCollection()
    {
        $column = $this->createValidColumn();
        $collection = new Collection();
        $collection->add($column->getName(), $column);
        return $collection;
    }

    protected function createInvalidCollection()
    {
        $column = $this->createInvalidColumn();
        $collection = new Collection();
        $collection->add($column->getName(), $column);
        return $collection;
    }

    public function testValidateShouldReturnTrueIfErrorsNotFound()
    {
        $primaryKey = $this->createValidPrimaryKey();
        $collection = $this->createValidCollection();
        $validator = new IntegrityValidator($primaryKey, $collection);
        $this->assertTrue($validator->validate());
    }

    public function testValidateShouldReturnFalseIfErrorsFound()
    {
        $primaryKey = $this->createValidPrimaryKey();
        $collection = $this->createInvalidCollection();
        $validator = new IntegrityValidator($primaryKey, $collection);
        $this->assertFalse($validator->validate());
    }

    public function testGetErrorsShouldReturnListOfErrors()
    {
        $primaryKey = $this->createValidPrimaryKey();
        $collection = $this->createInvalidCollection();
        $validator = new IntegrityValidator($primaryKey, $collection);
        $this->assertFalse($validator->validate());
        $expected = [
            'ID' => [
                'Constraint do not exist in columns list',
            ]
        ];
        $result = $validator->getErrors();
        $this->assertEquals(
            $expected,
            $result
        );
    }
}
