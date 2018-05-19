<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Factories;

use Barryvanveen\CCA\Cell;
use Barryvanveen\CCA\Coordinate;
use Barryvanveen\CCA\Grid;
use Barryvanveen\CCA\Interfaces\ConfigInterface;
use Barryvanveen\CCA\Neighborhood;

class GridFactory
{
    public static function create(ConfigInterface $config)
    {
        self::setSeed($config);

        $cells = self::getCells($config);

        $neighbors = self::getNeighbors($config);

        return new Grid($config, $cells, $neighbors);
    }

    protected static function setSeed(ConfigInterface $config)
    {
        mt_srand($config->seed());
    }

    protected static function getCells(ConfigInterface $config)
    {
        $cells = [];

        for ($row = 0; $row < $config->rows(); $row++) {
            for ($column = 0; $column < $config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $config->columns());

                $cells[$coordinate->position()] = new Cell($config);
            }
        }

        return $cells;
    }

    protected static function getNeighbors(ConfigInterface $config)
    {
        $neighbors = [];

        for ($row = 0; $row < $config->rows(); $row++) {
            for ($column = 0; $column < $config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $config->columns());

                $neighborhood = new Neighborhood($config, $coordinate);

                $neighbors[$coordinate->position()] = $neighborhood->getNeighbors();
            }
        }

        return $neighbors;
    }
}
