<?php

namespace Highideas\SqlToMigration\Test\Queries\Constraints;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Constraints\PrimaryKey;

class PrimaryKeyTest extends PHPUnit_Framework_TestCase
{
    public function testNewInstanceOfPrimaryKeyShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        try {
            new PrimaryKey('Invalid column query');
        }

        catch (\Highideas\SqlToMigration\Exceptions\InvalidColumnException $expected) {
            $this->assertEquals('Invalid column query', $expected->getName());
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testPrimaryKeyShouldReturnColumnsNamesWhenTableDefinition()
    {
        $primaryKey = new PrimaryKey('PRIMARY KEY  (`RoleID`,`PermissionID`)');
        $expected = ['RoleID','PermissionID',];
        $this->assertEquals($expected, $primaryKey->getColumns());
    }

    public function testPrimaryKeyShouldReturnColumnsNamesWhenColumnDefinition()
    {
        $primaryKey = new PrimaryKey('`ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,');
        $expected = ['ID',];
        $this->assertEquals($expected, $primaryKey->getColumns());
    }
}
