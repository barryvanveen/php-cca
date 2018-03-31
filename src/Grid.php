<?php

namespace Barryvanveen\CCA;

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

                $this->neighbors[$coordinate->position()] =
                    Neighborhood::createNeighborhoodForCoordinate($this->config, $coordinate);
            }
        }
    }

    public function computeNextState()
    {
        foreach ($this->cells as $position => $cell) {
            $neighborCoordinates = $this->neighbors[$position];

            $neighborStates = $this->getStatesForCoordinates($neighborCoordinates);

            $this->cells[$position]->computeNextState($neighborStates);
        }
    }

    protected function getStatesForCoordinates(array $coordinates): array
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
