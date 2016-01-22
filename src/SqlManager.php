<?php

namespace Highideas\SqlToMigration;

use Highideas\SqlToMigration\Queries\QueryFactory;
use Highideas\SqlToMigration\Collections\Collection;

class SqlManager
{
    protected $rawQuery;
    protected $queries;
    protected $delimiter = ';';

    public function __construct($rawQuery, Collection $queries)
    {
        $this->rawQuery = $rawQuery;
        $this->queries = $queries;
    }

    protected function defineQuery($rawQuery)
    {
        $preFormatedRawQuery = trim(strtolower($rawQuery));
        if (strpos($preFormatedRawQuery, 'create table') !== false) {
            $query = QueryFactory::instantiate('create', $rawQuery);
            $this->getQueries()->add($query->getTable(), $query);
        }
    }

    public function run()
    {
        $queries = explode($this->delimiter, $this->getRawQuery());
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
