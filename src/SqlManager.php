<?php

namespace Highideas\SqlToMigration;

use Highideas\SqlToMigration\Queries\QueryFactory;

class SqlManager
{
    protected $rawQuery;
    protected $query;

    public function __constructor($rawQuery)
    {
        $this->rawQuery = $rawQuery;
        $this->defineQuery();
    }

    protected function defineQuery()
    {
        $preFormatedRawQuery = trim(strtolower($this->rawQuery));

        if (strpos($preFormatedRawQuery, 'create table') !== false) {
            $this->query = QueryFactory::instantiate('create', $this->rawQuery);
            return true;
        }
    }
}
