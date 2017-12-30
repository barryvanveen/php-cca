<?php

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Grid\GridIterator;
use Traversable;

class Grid implements \IteratorAggregate
{
    /** @var Config */
    protected $config;

    /** @var Cell[] */
    protected $cells = [];

    /** @var Coordinate[][] */
    protected $neighbors = [];

    public function __construct(Config $config)
    {
        $this->config = $config;

        for ($row = 0; $row < $this->config->rows; $row++) {
            //$cells[$row] = [];

            for ($column = 0; $column < $this->config->columns; $column++) {
                $coordinate = new Coordinate($row, $column, $this->config->columns);

                $this->cells[$coordinate->position()] = new Cell($this->config);

                $this->neighbors[$coordinate->position()] = $this->getMooreNeighbors($coordinate);
            }
        }
    }

    protected function getMooreNeighbors(Coordinate $coordinate, int $size = 1): array
    {
        $neigbors = [];

        $size = abs($size);

        for ($rowOffset = -1 * $size; $rowOffset <= $size; $rowOffset++) {
            for ($columnOffset = -1 * $size; $columnOffset <= $size; $columnOffset++) {
                if ($rowOffset === 0 && $columnOffset === 0) {
                    continue;
                }

                $neigbors[] = new Coordinate(
                    $this->wrapRow($coordinate->row(), $rowOffset),
                    $this->wrapColumn($coordinate->column(), $columnOffset),
                    $this->config->columns
                );
            }
        }

        return $neigbors;
    }

    protected function wrapRow(int $row, int $rowOffset): int
    {
        $row = $row + $rowOffset;

        if ($row < 0) {
            return $row + $this->config->rows;
        }

        return $row % $this->config->rows;
    }

    protected function wrapColumn(int $column, int $columnOffset): int
    {
        $column = $column + $columnOffset;

        if ($column < 0) {
            return $column + $this->config->columns;
        }

        return $column % $this->config->columns;
    }

    public function computeNextState()
    {
        /**
         * @var Coordinate $coordinate
         * @var Cell $cell
         */
        foreach ($this as $coordinate => $cell) {
            $neighborCoordinates = $this->neighbors[$coordinate->position()];

            $neighborStates = $this->getNeighborStates($neighborCoordinates);

            $this->cells[$coordinate->position()]->computeNextState($neighborStates);
        }
    }

    protected function getNeighborStates(array $coordinates): array
    {
        $states = [];

        /** @var Coordinate $coordinate */
        foreach ($coordinates as $coordinate) {
            $states[] = $this->cells[$coordinate->position()]->getState();
        }

        return $states;
    }

    public function setNextState()
    {
        /**
         * @var Coordinate $coordinate
         * @var Cell $cell
         */
        foreach ($this as $coordinate => $cell) {
            $this->cells[$coordinate->position()]->setNextState();
        }
    }
    
    public function __toString(): string
    {
        $string = '';

        // first line: numbered columns
        for ($column = 0; $column < $this->config->columns; $column++) {
            if ($column === 0) {
                $string .= sprintf("  ");
            }
            $string .= sprintf("%.2d ", $column);
        }
        $string .= sprintf("\n");

        // rows
        for ($row = 0; $row < $this->config->rows; $row++) {
            // number of current row
            $string .= sprintf("%.2d ", $row);

            // cell states
            for ($column = 0; $column < $this->config->columns; $column++) {
                $coordinate = new Coordinate($row, $column, $this->config->columns);
                $string .= sprintf("%s ", $this->cells[$coordinate->position()]);
            }
            $string .= sprintf("\n");
        }

        $string .= sprintf("\n");

        return $string;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php

     * @return Traversable
     */
    public function getIterator()
    {
        return new GridIterator($this->cells, $this->config->columns);
    }
}
