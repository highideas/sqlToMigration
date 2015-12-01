<?php

namespace Highideas\SqlToMigration\queries;

use Highideas\SqlToMigration\helpers;
use Exception;

class QueryFactory
{
	public static function instantiate($query)
	{
        $query = StringHelper::pascalCase($type);

        $file = __DIR__ . DIRECTORY_SEPARATOR . $query . ".php";
        if (!is_file($file)) {
            throw new Exception('File Not Found: ' . $file);
        }
        
        $class = __NAMESPACE__ . "\\{$query}";
        return new $class();
	}
}