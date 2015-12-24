<?php

namespace Highideas\SqlToMigration;

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
            $this->query = QueryFactory::instantiate('create');
            return true;
        }
    }
}
