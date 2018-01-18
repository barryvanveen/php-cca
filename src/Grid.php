<?php

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException;

class Grid
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

        for ($row = 0; $row < $this->config->rows(); $row++) {
            for ($column = 0; $column < $this->config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $this->config->columns());

                $this->cells[$coordinate->position()] = new Cell($this->config);

                $this->neighbors[$coordinate->position()] = $this->getNeighbors($coordinate);
            }
        }
    }

    protected function getNeighbors(Coordinate $coordinate)
    {
        switch ($this->config->neighborhoodType()) {
            case Config::NEIGHBORHOOD_TYPE_MOORE:
                return $this->getMooreNeighbors($coordinate);
            case Config::NEIGHBORHOOD_TYPE_NEUMANN:
                return $this->getNeumannNeighbors($coordinate);
        }

        throw new InvalidNeighborhoodTypeException();
    }

    /**
     * Retrieve an array of Moore neighborhood neighbors for the given coordinate.
     *
     * @param \Barryvanveen\CCA\Coordinate $coordinate
     *
     * @return Coordinate[]
     */
    protected function getMooreNeighbors(Coordinate $coordinate): array
    {
        $neigbors = [];

        $size = abs($this->config->neighborhoodSize());

        for ($rowOffset = -1 * $size; $rowOffset <= $size; $rowOffset++) {
            for ($columnOffset = -1 * $size; $columnOffset <= $size; $columnOffset++) {
                if ($rowOffset === 0 && $columnOffset === 0) {
                    continue;
                }

                $neigbors[] = new Coordinate(
                    $this->wrapRow($coordinate->row(), $rowOffset),
                    $this->wrapColumn($coordinate->column(), $columnOffset),
                    $this->config->columns()
                );
            }
        }

        return $neigbors;
    }

    /**
     * Retrieve an array of Neumann neighborhood neighbors for the given coordinate.
     *
     * @param \Barryvanveen\CCA\Coordinate $coordinate
     *
     * @return Coordinate[]
     */
    protected function getNeumannNeighbors(Coordinate $coordinate): array
    {
        $neigbors = [];

        $size = abs($this->config->neighborhoodSize());

        for ($rowOffset = -1 * $size; $rowOffset <= $size; $rowOffset++) {
            for ($columnOffset = -1 * $size; $columnOffset <= $size; $columnOffset++) {
                if ($rowOffset === 0 && $columnOffset === 0) {
                    continue;
                }

                if ((abs($rowOffset) + abs($columnOffset)) > $this->config->neighborhoodSize()) {
                    continue;
                }

                $neigbors[] = new Coordinate(
                    $this->wrapRow($coordinate->row(), $rowOffset),
                    $this->wrapColumn($coordinate->column(), $columnOffset),
                    $this->config->columns()
                );
            }
        }

        return $neigbors;
    }

    protected function wrapRow(int $row, int $rowOffset): int
    {
        $row = $row + $rowOffset;

        if ($row < 0) {
            return $row + $this->config->rows();
        }

        return $row % $this->config->rows();
    }

    protected function wrapColumn(int $column, int $columnOffset): int
    {
        $column = $column + $columnOffset;

        if ($column < 0) {
            return $column + $this->config->columns();
        }

        return $column % $this->config->columns();
    }

    public function computeNextState()
    {
        foreach ($this->cells as $position => $cell) {
            $neighborCoordinates = $this->neighbors[$position];

            $neighborStates = $this->getNeighborStates($neighborCoordinates);

            $this->cells[$position]->computeNextState($neighborStates);
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
        foreach ($this->cells as $position => $cell) {
            $this->cells[$position]->setNextState();
        }
    }

    public function toArray(): array
    {
        $states = [];

        foreach ($this->cells as $position => $cell) {
            $states[] = $cell->getState();
        }

        return $states;
    }
    
    public function __toString(): string
    {
        $string = '';

        // first line: numbered columns
        for ($column = 0; $column < $this->config->columns(); $column++) {
            if ($column === 0) {
                $string .= sprintf("  ");
            }
            $string .= sprintf("%.2d ", $column);
        }
        $string .= sprintf("\n");

        // rows
        for ($row = 0; $row < $this->config->rows(); $row++) {
            // number of current row
            $string .= sprintf("%.2d ", $row);

            // cell states
            for ($column = 0; $column < $this->config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $this->config->columns());
                $string .= sprintf("%s ", $this->cells[$coordinate->position()]);
            }
            $string .= sprintf("\n");
        }

        $string .= sprintf("\n");

        return $string;
    }
}
