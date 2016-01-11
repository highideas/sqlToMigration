<?php

namespace Highideas\SqlToMigration\Test\Queries\Validators;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Collections\Collection;
use Highideas\SqlToMigration\Queries\Validators\IntegrityValidator;
use Highideas\SqlToMigration\Queries\Statements\Statement;

class IntegrityValidatorTest extends PHPUnit_Framework_TestCase
{

    protected $validStatement = '`ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,';
    protected $invalidStatement = 'invalid column';

    protected function createValidStatement()
    {
        $statement = new Statement();
        $statement->run(['`ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,']);
        return $statement;
    }

    protected function createInvalidStatement()
    {
        $statement = new Statement();
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
        $validStatement = $this->createValidStatement();
        $validator = new IntegrityValidator($validStatement);
        $result = $validator->validate();
        $this->assertTrue($result);
    }

    public function testValidateShouldReturnFalseIfErrorsFound()
    {
        $invalidStatement = $this->createInvalidStatement();
        $validator = new IntegrityValidator($invalidStatement);
        $this->assertFalse($validator->validate());
    }

    public function testGetErrorsShouldReturnListOfErrors()
    {
        $invalidStatement = $this->createInvalidStatement();
        $validator = new IntegrityValidator($invalidStatement);
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
