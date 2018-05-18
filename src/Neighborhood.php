<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

class Neighborhood
{
    /** @var Config */
    protected $config;

    /** @var Coordinate */
    protected $coordinate;

    /**
     * Neighborhood constructor.
     *
     * @param Config     $config
     * @param Coordinate $coordinate
     */
    public function __construct(Config $config, Coordinate $coordinate)
    {
        $this->config = $config;

        $this->coordinate = $coordinate;
    }

    /**
     * @return Coordinate[]
     *
     * @throws \Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException
     */
    public function getNeighbors(): array
    {
        $neighborhoodType = $this->config->neighborhoodType();

        $method = 'get'.ucfirst($neighborhoodType).'Neighbors';

        return $this->{$method}($this->coordinate);
    }

    /**
     * Retrieve an array of Moore neighborhood neighbors for the given coordinate.
     *
     * @param Coordinate $coordinate
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
     * @param Coordinate $coordinate
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
}
