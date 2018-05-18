<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Factories;

use Barryvanveen\CCA\Cell;
use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Coordinate;
use Barryvanveen\CCA\Grid;
use Barryvanveen\CCA\Neighborhood;

class GridFactory
{
    public static function create(Config $config)
    {
        self::setSeed($config);

        $cells = self::getCells($config);

        $neighbors = self::getNeighbors($config);

        return new Grid($config, $cells, $neighbors);
    }

    protected static function setSeed(Config $config)
    {
        mt_srand($config->seed());
    }

    protected static function getCells(Config $config)
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

    protected static function getNeighbors(Config $config)
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
