<?php

namespace Barryvanveen\CCA;

class Coordinate
{
    /** @var int */
    protected $row;

    /** @var int */
    protected $column;

    /** @var int */
    protected $columns;

    /** @var int */
    protected $position;

    public function __construct(int $row, int $column, int $columns)
    {
        $this->row = $row;
        $this->column = $column;
        $this->columns = $columns;
        $this->position = $this->calculatePosition();
    }

    public function __toString(): string
    {
        return sprintf("%d, %d", $this->row, $this->column);
    }

    public function row(): int
    {
        return $this->row;
    }

    public function column(): int
    {
        return $this->column;
    }

    protected function calculatePosition(): int
    {
        return ($this->row * $this->columns) + $this->column;
    }

    public function position(): int
    {
        return $this->position;
    }
}
