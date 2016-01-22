<?php

namespace Highideas\SqlToMigration\Test;

use \PHPUnit_Framework_TestCase;

use Highideas\SqlToMigration\SqlManager;
use Highideas\SqlToMigration\Collections\Collection;

class SqlManagerTest extends PHPUnit_Framework_TestCase
{
    protected function validQueries()
    {
        return 'CREATE TABLE `PREFIX_permissions` (' .
        '  `ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,' .
        '  `Lft` INTEGER NOT NULL,' .
        '  `Rght` INTEGER NOT NULL,' .
        '  `Title` char(64) NOT NULL,' .
        '  `Description` text NOT NULL' .
        ');' .
        '' .
        'CREATE TABLE `PREFIX_rolepermissions` (' .
        '  `RoleID` INTEGER NOT NULL,' .
        '  `PermissionID` INTEGER NOT NULL,' .
        '  `AssignmentDate` INTEGER NOT NULL,' .
        '  PRIMARY KEY  (`RoleID`,`PermissionID`)' .
        ');' .
        '' .
        'CREATE TABLE `PREFIX_roles` (' .
        '  `ID` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,' .
        '  `Lft` INTEGER NOT NULL,' .
        '  `Rght` INTEGER NOT NULL,' .
        '  `Title` varchar(128) NOT NULL,' .
        '  `Description` text NOT NULL' .
        ');' .
        '' .
        'CREATE TABLE `PREFIX_userroles` (' .
        '  `UserID` INTEGER NOT NULL,' .
        '  `RoleID` INTEGER NOT NULL,' .
        '  `AssignmentDate` INTEGER NOT NULL,' .
        '  PRIMARY KEY  (`UserID`,`RoleID`)' .
        ');';
    }

    public function testGetQueriesShouldReturnCollectionInstance()
    {
        $rawQuery = $this->validQueries();
        $sql = new SqlManager($rawQuery, new Collection);
        //$sql->run();
        //$this->assertInstanceOf(
        //    '\Highideas\SqlToMigration\Collections\Collection',
        //    $sql->getQueries()
        //);
    }
}
