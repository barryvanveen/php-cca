<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Config\NeighborhoodOptions;

class Neighborhood
{
    /** @var Config */
    protected $config;

    /** @var Coordinate */
    protected $coordinate;

    /**
     * Neighborhood constructor.
     *
     * @param Config $config
     * @param Coordinate $coordinate
     */
    public function __construct(Config $config, Coordinate $coordinate)
    {
        $this->config = $config;

        $this->coordinate = $coordinate;
    }

    /**
     * @return Coordinate[]
     */
    public function getNeighbors(): array
    {
        $neighbors = [];

        $offsets = range(-1 * $this->config->neighborhoodSize(), $this->config->neighborhoodSize());

        foreach ($offsets as $rowOffset) {
            foreach ($offsets as $columnOffset) {
                if (!$this->isValidNeighbor($rowOffset, $columnOffset)) {
                    continue;
                }

                $neighbors[] = $this->createCoordinateFromOffsets($this->coordinate, $rowOffset, $columnOffset);
            }
        }

        return $neighbors;
    }

    protected function createCoordinateFromOffsets(Coordinate $current, int $rowOffset, int $columnOffset): Coordinate
    {
        return new Coordinate(
            $this->wrapRow($current->row(), $rowOffset),
            $this->wrapColumn($current->column(), $columnOffset),
            $this->config->columns()
        );
    }

    /**
     * Determine if the offsets result in a valid neighbor.
     *
     * @param int $rowOffset
     * @param int $columnOffset
     *
     * @return bool
     */
    protected function isValidNeighbor(int $rowOffset, int $columnOffset): bool
    {
        if (abs($rowOffset) + abs($columnOffset) === 0) {
            return false;
        }

        if ($this->config->neighborhoodType() === NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE) {
            return true;
        }

        if ((abs($rowOffset) + abs($columnOffset)) > $this->config->neighborhoodSize()) {
            return false;
        }

        return true;
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
