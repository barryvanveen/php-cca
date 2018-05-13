<?php

namespace Barryvanveen\CCA;

class GridBuilder
{
    /** @var Config */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->setSeed();
    }

    private function setSeed()
    {
        mt_srand($this->config->seed());
    }

    /**
     * Get an array of cells. Together these cells form the grid.
     *
     * @return array
     */
    public function getCells(): array
    {
        $cells = [];

        for ($row = 0; $row < $this->config->rows(); $row++) {
            for ($column = 0; $column < $this->config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $this->config->columns());

                $cells[$coordinate->position()] = new Cell($this->config);
            }
        }

        return $cells;
    }

    /**
     * Get an array of neighbors for each cell in the grid.
     *
     * @return array
     * @throws Exceptions\InvalidNeighborhoodTypeException
     */
    public function getNeighbors(): array
    {
        $neighbors = [];

        for ($row = 0; $row < $this->config->rows(); $row++) {
            for ($column = 0; $column < $this->config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $this->config->columns());

                $neighborhood = new Neighborhood($this->config, $coordinate);

                $neighbors[$coordinate->position()] = $neighborhood->getNeighbors();
            }
        }

        return $neighbors;
    }
}
