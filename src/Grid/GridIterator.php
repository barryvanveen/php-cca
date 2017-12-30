<?php

namespace Barryvanveen\CCA\Grid;

use Barryvanveen\CCA\Cell;
use Barryvanveen\CCA\Coordinate;
use Iterator;

class GridIterator implements Iterator
{
    /** @var int */
    private $currentRow;

    /** @var int */
    private $currentColumn;

    /** @var array */
    private $cells;

    /** @var int  */
    private $columns;

    public function __construct(array $cells, int $columns)
    {
        $this->currentRow = 0;
        $this->currentColumn = 0;
        $this->cells = $cells;
        $this->columns = $columns;
    }
    
    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     *
     * @return Cell
     */
    public function current()
    {
        return $this->cells[$this->key()->position()];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     */
    public function next()
    {
        $this->currentColumn++;

        if (!$this->valid()) {
            $this->currentRow++;
            $this->currentColumn = 0;
        }
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     *
     * @return Coordinate
     */
    public function key()
    {
        return new Coordinate($this->currentRow, $this->currentColumn, $this->columns);
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php

     * @return boolean
     */
    public function valid()
    {
        return isset($this->cells[$this->key()->position()]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     */
    public function rewind()
    {
        $this->currentRow = 0;
        $this->currentColumn = 0;
    }
}
