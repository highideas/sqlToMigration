<?php

namespace Highideas\SqlToMigration\Exceptions;

use \InvalidArgumentException;

class InvalidColumnException extends InvalidArgumentException
{
    protected $name;

    /**
     * New Instance
     *
     * @param string $name    validator name
     * @param string $message exception message
     */
    public function __construct($name, $message = '')
    {
        parent::__construct($message);
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
