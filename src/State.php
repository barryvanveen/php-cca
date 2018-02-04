<?php

namespace Barryvanveen\CCA;

class State
{
    /** @var array */
    protected $array;

    /** @var string */
    protected $string;
    
    public function __construct(Grid $grid)
    {
        $this->array = $grid->toArray();

        $this->string = $grid->__toString();
    }

    public function toArray(): array
    {
        return $this->array;
    }

    public function toHash(): string
    {
        return hash('crc32', $this->string);
    }

    public function __toString()
    {
        return $this->string;
    }
}
