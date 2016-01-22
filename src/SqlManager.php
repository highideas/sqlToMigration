<?php

namespace Highideas\SqlToMigration;

use Highideas\SqlToMigration\Queries\QueryFactory;
use Highideas\SqlToMigration\Collections\Collection;

class SqlManager
{
    protected $rawQuery;
    protected $queries;
    protected $delimiter = ';';

    public function __constructor($rawQuery, Collection $queries)
    {
        var_dump('AAAA');
        var_dump($rawQuery);
        var_dump('AAAA');
        $this->rawQuery = $rawQuery;
        $this->queries = $queries;
    }

    protected function defineQuery($rawQuery)
    {
        var_dump($rawQuery);
        $preFormatedRawQuery = trim(strtolower($rawQuery));
        if (strpos($preFormatedRawQuery, 'create table') !== false) {
            $query = QueryFactory::instantiate('create', $rawQuery);
            $this->getQueries()->add($column->getTable(), $query);
        }
    }

    public function run()
    {
        $queries = explode($this->delimiter, $this->getRawQuery());
        var_dump($this->getRawQuery());
        var_dump($queries);
        foreach ($queries as $query) {
            $this->defineQuery($query);
        }
    }

    public function getQueries()
    {
        return $this->queries;
    }

    public function getRawQuery()
    {
        return $this->rawQuery;
    }
}
