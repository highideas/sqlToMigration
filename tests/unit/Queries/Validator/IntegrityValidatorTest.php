<?php

namespace Highideas\SqlToMigration\Test\Queries\Validators;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Collections\Collection;
use Highideas\SqlToMigration\Queries\Statements\Statement;
use Highideas\SqlToMigration\Queries\Validators\IntegrityValidator;
use Highideas\SqlToMigration\Queries\Statements\Constraints\PrimaryKey;

class IntegrityValidatorTest extends PHPUnit_Framework_TestCase
{
    protected function createValidStatement()
    {
        $statement = new Statement(new Collection, new PrimaryKey, new IntegrityValidator);
        $statement->run(['`ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,']);
        return $statement;
    }

    protected function createInvalidStatement()
    {
        $statement = new Statement(new Collection, new PrimaryKey, new IntegrityValidator);
        $statement->run(
            [
                'invalid column,',
                '`NAME` VARCHAR,',
                'PRIMARY KEY (`ID`),'
            ]
        );
        return $statement;
    }

    public function testValidateShouldReturnTrueIfErrorsNotFound()
    {
        $statement = $this->createValidStatement();
        $validator = new IntegrityValidator();
        $validator->setStatement($statement);
        $result = $validator->validate();
        $this->assertTrue($result);
    }

    public function testValidateShouldReturnFalseIfErrorsFound()
    {
        $statement = $this->createInvalidStatement();
        $validator = new IntegrityValidator();
        $validator->setStatement($statement);
        $this->assertFalse($validator->validate());
    }

    public function testGetErrorsShouldReturnListOfErrors()
    {
        $statement = $this->createInvalidStatement();
        $validator = new IntegrityValidator();
        $validator->setStatement($statement);
        $this->assertFalse($validator->validate());
        $expected = [
            'ID' => [
                'Constraint do not exist in columns list',
            ],
            'invalidColumnsQuantityExpected' => [
                'Columns Quantity Expected: 3 Columns Quantity Found: 1',
            ],
        ];
        $result = $validator->getErrors();
        $this->assertEquals(
            $expected,
            $result,
            'Expected: ' . print_r($expected, true) .
            'Result: ' . print_r($result, true)
        );
    }
}
