<?php

namespace Barryvanveen\CCA;

/**
 * @property-read int $columns;
 * @property-read int $rows;
 * @property-read int $states;
 * @property-read int $threshold;
 */
class Config
{
    protected $rows = 10;

    protected $columns = 10;

    protected $states = 5;

    protected $threshold = 1;

    public function __construct(array $config)
    {
        // ...
    }

    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Property $name does not exist");
        }

        return $this->$name;
    }
}
