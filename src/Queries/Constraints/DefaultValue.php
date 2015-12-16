<?php

namespace Highideas\SqlToMigration\Queries\Constraints;

use Highideas\SqlToMigration\Exceptions\InvalidColumnException;

trait DefaultValue {

    protected $default = null;
    protected $defaultRegex = '';

    protected function setDefault()
    {

        foreach ($this->splitColumn as $key => $value) {
            if (strpos(strtolower($value), 'default') !== false) {
                $this->default = preg_replace(
                    $this->getDefaultRegex(),
                    "$1",
                    $value
                );
                break;
            }
        }
        if (empty($this->default)) {
            throw new InvalidColumnException($this->getRaw(), 'Invalid Default Value.');
        }
    }

    public function setDefaultRegex($regex)
    {
        $this->defaultRegex = $regex;
    }

    public function getDefaultRegex()
    {
        return $this->defaultRegex;
    }

    public function hasDefault()
    {
        return strpos(strtolower($this->getRaw()), 'default') !== false;
    }

    public function getDefault()
    {
        return $this->default;
    }
}
