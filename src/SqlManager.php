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
        if ($this->isCreateTable()) {
            $this->query = QueryFactory::instantiate('create_table');
            return true;
        }
    }

    protected function isCreateTable()
    {
        $preFormatedRawQuery = trim(strtolower($this->rawQuery));
        return strpos($preFormatedRawQuery, 'create table') !== false;
    }
}