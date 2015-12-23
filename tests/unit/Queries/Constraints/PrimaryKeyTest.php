<?php

namespace Highideas\SqlToMigration\Test\Queries\Constraints;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\Queries\Constraints\PrimaryKey;

class PrimaryKeyTest extends PHPUnit_Framework_TestCase
{
    public function testNewInstanceOfPrimaryKeyShouldReturnInvalidColumnExceptionWhenInvalidParamPassed()
    {
        try {
            $primaryKey = new PrimaryKey();
            $primaryKey->addColumn('Invalid column query');
        }

        catch (\Highideas\SqlToMigration\Exceptions\InvalidColumnException $expected) {
            $this->assertEquals('Invalid column query', $expected->getName());
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testPrimaryKeyShouldReturnColumnsNamesWhenTableDefinition()
    {
        $primaryKey = new PrimaryKey();
        $primaryKey->addColumn('PRIMARY KEY  (`RoleID`,`PermissionID`)');
        $expected = ['RoleID' => 'RoleID','PermissionID' => 'PermissionID',];
        $this->assertEquals($expected, $primaryKey->getColumns());
    }

    public function testPrimaryKeyShouldReturnColumnsNamesWhenColumnDefinition()
    {
        $primaryKey = new PrimaryKey();
        $primaryKey->addColumn('`ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,');
        $expected = ['ID' => 'ID',];
        $this->assertEquals($expected, $primaryKey->getColumns());
    }

    public function testPrimaryKeyShouldToConcentrateColumnsNamesWhenColumnDefinition()
    {
        $primaryKey = new PrimaryKey();
        $primaryKey->addColumn('`ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,');
        $primaryKey->addColumn('PRIMARY KEY  (`RoleID`,`PermissionID`)');
        $expected = ['ID' => 'ID', 'RoleID' => 'RoleID','PermissionID' => 'PermissionID',];
        $this->assertEquals($expected, $primaryKey->getColumns());
    }
}
